<?php

namespace Tests\Bootstrap;

use App\Bootstrap\RouteManager;
use App\Controllers;
use Slim\App;
use Tests\TestCase;

/** @covers \App\Bootstrap\RouteManager */
class RouteManagerTest extends TestCase
{
    public function test_it_registers_application_routes(): void
    {
        $app = $this->createMock(App::class);
        $app->expects($this->once())->method('post')->with(
            '/TEST_TELEGRAM_TOKEN', Controllers\Telegram::class
        );

        (new RouteManager($app, $this->config))();
    }
}
