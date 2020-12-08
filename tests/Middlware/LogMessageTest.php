<?php

namespace Tests\Middlware;

use App\Middleware\LogMessage;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use Monolog\Logger;
use Tests\TestCase;

/** @covers \App\Middleware\LogMessage */
class LogMessageTest extends TestCase
{
    /** @test */
    public function it_logs_the_incoming_message(): void
    {
        $logger = $this->createMock(Logger::class);
        $logger->expects($this->once())->method('info')->with('Incomming message', []);

        $middleware = new LogMessage($logger);

        $middleware->received(
            new IncomingMessage('/test argument', 'Arthur Dent', 'Ford Prefect'),
            fn (IncomingMessage $message) => $message,
            $this->botman
        );
    }
}
