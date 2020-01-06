<?php

namespace App\Bootstrap;

use App\Providers;
use DI\Bridge\Slim\Bridge;
use DI\Container;
use PHLAK\Config\Config;
use Slim\App;
use Tightenco\Collect\Support\Collection;

class AppManager
{
    /** @const Array of app providers */
    protected const PROVIDERS = [
        Providers\ConfigProvider::class,
        Providers\LoggingProvider::class,
        Providers\BotManProvider::class,
        Providers\CommandsProvider::class,
    ];

    /** @var Container The applicaiton container */
    protected $container;

    /** @var Config The application config */
    protected $config;

    /**
     * Create a new Provider object.
     *
     * @param \DI\Container $container
     */
    public function __construct(Container $container, Config $config)
    {
        $this->container = $container;
        $this->config = $config;
    }

    /**
     * Setup and configure the application.
     *
     * @return \Slim\App
     */
    public function __invoke(): App
    {
        $this->registerProviders();

        return Bridge::create($this->container);
    }

    /**
     * Register application providers.
     *
     * @return void
     */
    protected function registerProviders(): void
    {
        Collection::make(self::PROVIDERS)->merge(
            $this->config->get('app.providers', [])
        )->each(function (string $provider) {
            $this->container->call($provider);
        });
    }
}
