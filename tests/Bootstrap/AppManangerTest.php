<?php

namespace Tests\Bootstrap;

use App\Bootstrap\AppManager;
use Slim\App;
use Tests\TestCase;

/** @covers \App\Bootstrap\AppManager */
class AppManangerTest extends TestCase
{
    /** @test */
    public function it_returns_an_app_instance()
    {
        $app = (new AppManager($this->container))();

        $this->assertInstanceOf(App::class, $app);
        $this->assertSame($this->container, $app->getContainer());
    }
}
