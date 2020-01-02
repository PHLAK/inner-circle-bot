<?php

namespace App\Bootstrap;

use PHLAK\Config\Config;

class ConfigProvider extends Provider
{
    /**
     * Register the application config.
     *
     * @return void
     */
    public function __invoke(): void
    {
        $this->container->set(Config::class, Config::createFromDirectory(
            $this->container->get('base_path') . DIRECTORY_SEPARATOR . 'config')
        );
    }
}
