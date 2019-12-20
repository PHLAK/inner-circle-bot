<?php

namespace App\Bootstrap;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;
use DI\Container;

class BotManProvider
{
    /** @var Container The application container */
    protected $container;

    /**
     * Create a new BotmanProvider class.
     *
     * @param \DI\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Set up and configure Botman.
     *
     * @return void
     */
    public function __invoke()
    {
        $this->container->set(BotMan::class, function () {
            DriverManager::loadDriver(TelegramDriver::class);

            return BotManFactory::create($this->container->get('app.config'));
        });
    }
}
