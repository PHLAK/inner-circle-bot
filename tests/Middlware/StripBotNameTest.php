<?php

namespace Tests\Middlware;

use App\Middleware\StripBotName;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use Tests\TestCase;

/** @covers \App\Middleware\StripBotName */
class StripBotNameTest extends TestCase
{
    public function test_it_strips_a_bot_suffix_from_a_command(): void
    {
        $middleware = new StripBotName($this->container);

        $message = $middleware->received(
            new IncomingMessage('/test@TestBot argument', 'Arthur Dent', 'Ford Prefect'),
            function (IncomingMessage $message) {
                return $message;
            },
            $this->botman
        );

        $this->assertEquals('/test argument', $message->getText());
    }

    public function test_a_message_without_a_bot_suffix_remains_unchanged(): void
    {
        $middleware = new StripBotName($this->container);

        $message = $middleware->received(
            new IncomingMessage('/test argument', 'Arthur Dent', 'Ford Prefect'),
            function (IncomingMessage $message) {
                return $message;
            },
            $this->botman
        );

        $this->assertEquals('/test argument', $message->getText());
    }
}
