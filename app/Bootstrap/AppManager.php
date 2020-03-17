<?php

namespace App\Bootstrap;

use App\Providers;
use DI\Bridge\Slim\Bridge;
use DI\Container;
use Invoker\CallableResolver;
use PHLAK\Config\Interfaces\ConfigInterface;
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

    /** @var ConfigInterface The application config */
    protected $config;

    /** @var CallableResolver The callable resolver */
    protected $callableResolver;

    /**
     * Create a new Provider object.
     *
     * @param \DI\Container                            $container
     * @param \PHLAK\Config\Interfaces\ConfigInterface $config
     * @param \Invoker\CallableResolver                $callableResolver
     */
    public function __construct(
        Container $container,
        ConfigInterface $config,
        CallableResolver $callableResolver
    ) {
        $this->container = $container;
        $this->config = $config;
        $this->callableResolver = $callableResolver;
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
        Collection::make(self::PROVIDERS)->each(function (string $provider) {
            $this->container->call(
                $this->callableResolver->resolve($provider)
            );
        });
    }
}
