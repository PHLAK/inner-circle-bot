<?php

namespace App\Bootstrap;

use DI\Bridge\Slim\Bridge;
use DI\Container;
use Slim\App;

class AppManager
{
    /** @var Container The applicaiton container */
    protected $container;

    /**
     * Create a new Provider object.
     *
     * @param \DI\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Setup and configure the application.
     *
     * @param string $basePath
     *
     * @return \Slim\App
     */
    public function __invoke(string $basePath): App
    {
        $this->container->set('base_path', $basePath);
        $this->container->call(ProviderManager::class);

        return Bridge::create($this->container);
    }
}
