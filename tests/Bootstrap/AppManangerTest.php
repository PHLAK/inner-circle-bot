<?php

namespace Tests\Bootstrap;

use App\Bootstrap\AppManager;
use Slim\App;
use Tests\TestCase;

class AppManangerTest extends TestCase
{
    public function test_it_returns_an_app_instance()
    {
        $app = (new AppManager($this->container))($this->path());

        $this->assertInstanceOf(App::class, $app);
        $this->assertSame($this->container, $app->getContainer());
    }
}
