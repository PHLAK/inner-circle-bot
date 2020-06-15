<?php

namespace Tests\Middlware;

use App\Middleware\LogResponse;
use Monolog\Logger;
use Tests\TestCase;

/** @covers \App\Middleware\LogResponse */
class LogResponseTest extends TestCase
{
    public function test_it_logs_the_incoming_message(): void
    {
        $logger = $this->createMock(Logger::class);
        $logger->expects($this->once())->method('info')->with('Outgoing response', [
            'chat_id' => 1337,
            'text' => 'Test response; please ignore'
        ]);

        $middleware = new LogResponse($logger);

        $middleware->sending(json_decode(
            '{"chat_id": 1337, "text": "Test response; please ignore"}'
        ), fn ($payload) => $payload, $this->botman);
    }
}
