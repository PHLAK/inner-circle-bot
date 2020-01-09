<?php

namespace Tests\Middlware;

use App\Middleware\LogMessage;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use Monolog\Logger;
use Tests\TestCase;

class LogMessageTest extends TestCase
{
    public function test_it_logs_the_incoming_message(): void
    {
        $logger = $this->createMock(Logger::class);
        $logger->expects($this->once())->method('info')->with('Incomming message', []);

        $middleware = new LogMessage($logger);

        $middleware->received(
            new IncomingMessage('/test argument', 'Arthur Dent', 'Ford Prefect'),
            function (IncomingMessage $message) {
                return $message;
            },
            $this->botman
        );
    }
}
