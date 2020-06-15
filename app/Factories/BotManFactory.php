<?php

namespace App\Factories;

use App\Commands;
use App\Middleware;
use BotMan\BotMan;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;
use DI\Container;
use Psr\Log\LoggerInterface;
use Tightenco\Collect\Support\Collection;

class BotManFactory
{
    /** @var Container The application container */
    protected $container;

    /** @var LoggerInterface The application logger */
    protected $logger;

    /** Create a new BotmanFactory object. */
    public function __construct(Container $container, LoggerInterface $logger)
    {
        $this->container = $container;
        $this->logger = $logger;
    }

    /** Configure and return a new BotMan instance. */
    public function __invoke(): BotMan\BotMan
    {
        DriverManager::loadDriver(TelegramDriver::class);

        $botman = BotMan\BotManFactory::create(
            $this->container->get('botman_config')
        );

        $botman->middleware->received(new Middleware\LogMessage($this->logger));
        $botman->middleware->received(new Middleware\StripLeadingSlash);
        $botman->middleware->received(new Middleware\StripBotName($this->container));
        $botman->middleware->sending(new Middleware\LogResponse($this->logger));

        Collection::make($this->container->get('commands'))->each(
            function (string $command, string $pattern) use ($botman) {
                $botman->hears($pattern, $command);
            }
        );

        $botman->fallback(Commands\Fallback::class);

        return $botman;
    }
}
