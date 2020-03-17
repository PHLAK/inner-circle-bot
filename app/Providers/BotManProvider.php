<?php

namespace App\Providers;

use App\Middleware;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;
use DI\Container;
use PHLAK\Config\Interfaces\ConfigInterface;
use Psr\Log\LoggerInterface;

class BotManProvider
{
    /** @var Container The application container */
    protected $container;

    /** @var ConfigInterface The application config */
    protected $config;

    /** @var LoggerInterface The application logger */
    protected $logger;

    /**
     * Create a new BotmanProvider object.
     *
     * @param \DI\Container                            $container
     * @param \PHLAK\Config\Interfaces\ConfigInterface $config
     * @param \Psr\Log\LoggerInterface                 $logger
     */
    public function __construct(
        Container $container,
        ConfigInterface $config,
        LoggerInterface $logger
    ) {
        $this->container = $container;
        $this->config = $config;
        $this->logger = $logger;
    }

    /**
     * Register and configure BotMan.
     *
     * @return void
     */
    public function __invoke(): void
    {
        $this->container->set(BotMan::class, function (): BotMan {
            DriverManager::loadDriver(TelegramDriver::class);

            $botman = BotManFactory::create(
                $this->config->split('botman')->toArray()
            );

            $botman->middleware->received(new Middleware\LogMessage($this->logger));
            $botman->middleware->received(new Middleware\StripLeadingSlash);
            $botman->middleware->received(new Middleware\StripBotName($this->config));
            $botman->middleware->sending(new Middleware\LogResponse($this->logger));

            return $botman;
        });
    }
}
