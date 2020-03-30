<?php

namespace App\Bootstrap;

use App\Controllers;
use DI\Container;
use Slim\App;

class RouteManager
{
    /** @var App The application */
    protected $app;

    /** @var Container The application container */
    protected $container;

    public function __construct(App $app, Container $container)
    {
        $this->app = $app;
        $this->container = $container;
    }

    public function __invoke()
    {
        $this->app->post(
            sprintf('/%s', $this->container->get('telegram_token')),
            Controllers\Telegram::class
        );
    }
}
