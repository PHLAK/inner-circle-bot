<?php

namespace Tests\Providers;

use App\Providers\BotManProvider;
use BotMan\BotMan\BotMan;
use Psr\Log\LoggerInterface;
use Tests\TestCase;

class BotManProviderTest extends TestCase
{
    public function test_it_can_register_the_botman_component(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        (new BotManProvider($this->container, $this->config, $logger))();

        $botman = $this->container->get(BotMan::class);

        $this->assertInstanceOf(BotMan::class, $botman);
    }
}
