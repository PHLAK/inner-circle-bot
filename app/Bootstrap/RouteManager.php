<?php

namespace App\Bootstrap;

use App\Config;
use App\Controllers;
use Slim\App;

class RouteManager
{
    protected App $app;
    protected Config $config;

    public function __construct(App $app, Config $config)
    {
        $this->app = $app;
        $this->config = $config;
    }

    public function __invoke()
    {
        $this->app->post(
            sprintf('/%s', $this->config->get('telegram_token')),
            Controllers\Telegram::class
        );
    }
}
