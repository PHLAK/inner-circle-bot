<?php

namespace Tests\Middlware;

use App\Middleware\StripLeadingSlash;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use Tests\TestCase;

/** @covers \App\Middleware\StripLeadingSlash */
class StripLeadingSlashTest extends TestCase
{
    public function test_it_strips_a_leading_slash_from_a_command(): void
    {
        $middleware = new StripLeadingSlash();

        $message = $middleware->received(
            new IncomingMessage('/test argument', 'Arthur Dent', 'Ford Prefect'),
            fn (IncomingMessage $message) => $message,
            $this->botman
        );

        $this->assertEquals('test argument', $message->getText());
    }

    public function test_a_message_without_leading_slash_remains_unchanged(): void
    {
        $middleware = new StripLeadingSlash();

        $message = $middleware->received(
            new IncomingMessage('test argument', 'Arthur Dent', 'Ford Prefect'),
            fn (IncomingMessage $message) => $message,
            $this->botman
        );

        $this->assertEquals('test argument', $message->getText());
    }
}
