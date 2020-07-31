<?php

namespace App\Factories;

use App\Commands;
use App\Config;
use App\Middleware;
use BotMan\BotMan;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;
use Psr\Log\LoggerInterface;
use Tightenco\Collect\Support\Collection;

class BotManFactory
{
    protected Config $config;
    protected LoggerInterface $logger;

    /** Create a new BotmanFactory object. */
    public function __construct(Config $config, LoggerInterface $logger)
    {
        $this->config = $config;
        $this->logger = $logger;
    }

    /** Configure and return a new BotMan instance. */
    public function __invoke(): BotMan\BotMan
    {
        DriverManager::loadDriver(TelegramDriver::class);

        $botman = BotMan\BotManFactory::create(
            $this->config->get('botman_config')
        );

        $botman->middleware->received(new Middleware\LogMessage($this->logger));
        $botman->middleware->received(new Middleware\StripLeadingSlash);
        $botman->middleware->received(new Middleware\StripBotName($this->config));
        $botman->middleware->sending(new Middleware\LogResponse($this->logger));

        Collection::make($this->config->get('commands'))->each(
            function (string $command, string $pattern) use ($botman) {
                $botman->hears($pattern, $command);
            }
        );

        $botman->fallback(Commands\Fallback::class);

        return $botman;
    }
}
