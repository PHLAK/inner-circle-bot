<?php

namespace App\Providers;

use DI\Container;
use PHLAK\Config\Config;
use PHLAK\Config\Interfaces\ConfigInterface;

class ConfigProvider
{
    /** @var Container The applicaiton container */
    protected $container;

    /**
     * Create a new ConfigProvider object.
     *
     * @param \DI\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Register the application config.
     *
     * @return void
     */
    public function __invoke(): void
    {
        $this->container->set(ConfigInterface::class, Config::fromDirectory(
            $this->container->get('base_path') . DIRECTORY_SEPARATOR . 'config')
        );
    }
}
