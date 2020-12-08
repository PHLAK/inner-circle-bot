<?php

namespace Tests\Middlware;

use App\Middleware\StripBotName;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use Tests\TestCase;

/** @covers \App\Middleware\StripBotName */
class StripBotNameTest extends TestCase
{
    /** @test */
    public function it_strips_a_bot_suffix_from_a_command(): void
    {
        $middleware = new StripBotName($this->config);

        $message = $middleware->received(
            new IncomingMessage('/test@TestBot argument', 'Arthur Dent', 'Ford Prefect'),
            fn (IncomingMessage $message) => $message,
            $this->botman
        );

        $this->assertEquals('/test argument', $message->getText());
    }

    /** @test */
    public function a_message_without_a_bot_suffix_remains_unchanged(): void
    {
        $middleware = new StripBotName($this->config);

        $message = $middleware->received(
            new IncomingMessage('/test argument', 'Arthur Dent', 'Ford Prefect'),
            fn (IncomingMessage $message) => $message,
            $this->botman
        );

        $this->assertEquals('/test argument', $message->getText());
    }
}
