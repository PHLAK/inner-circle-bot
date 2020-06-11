<?php

namespace Tests\Factories;

use App\Factories\LoggerFactory;
use Psr\Log\LoggerInterface;
use Tests\TestCase;

/** @covers \App\Factories\LoggerFactory */
class LoggerFactoryTest extends TestCase
{
    public function test_it_can_register_the_logging_component(): void
    {
        $logger = (new LoggerFactory($this->container))();

        $this->assertInstanceOf(LoggerInterface::class, $logger);
        $this->assertEquals('php://stderr', $logger->getHandlers()[0]->getUrl());
    }
}
