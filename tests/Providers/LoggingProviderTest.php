<?php

namespace Tests\Providers;

use App\Providers\LoggingProvider;
use Psr\Log\LoggerInterface;
use Tests\TestCase;

class LoggingProviderTest extends TestCase
{
    public function test_it_can_register_the_logging_component(): void
    {
        (new LoggingProvider($this->container))();

        $logger = $this->container->get(LoggerInterface::class);

        $this->assertInstanceOf(LoggerInterface::class, $logger);
        $this->assertEquals('php://stderr', $logger->getHandlers()[0]->getUrl());
    }
}
