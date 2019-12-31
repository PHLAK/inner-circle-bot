<?php

namespace App\Bootstrap;

use App\Middleware;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;
use DI\Container;
use PHLAK\Config\Config;

class BotManProvider
{
    /** @var Container The application container */
    protected $container;

    /** @var Config The application config */
    protected $config;

    /**
     * Create a new BotmanProvider object.
     *
     * @param \DI\Container $container
     */
    public function __construct(Container $container, Config $config)
    {
        $this->container = $container;
        $this->config = $config;
    }

    /**
     * Set up and configure Botman.
     *
     * @return void
     */
    public function __invoke()
    {
        $this->container->set(BotMan::class, function (): BotMan {
            DriverManager::loadDriver(TelegramDriver::class);

            $botman = BotManFactory::create(
                $this->config->split('botman')->toArray()
            );

            $botman->middleware->received(new Middleware\StripLeadingSlash);
            $botman->middleware->received(new Middleware\StripBotName($this->config));

            return $botman;
        });
    }
}
