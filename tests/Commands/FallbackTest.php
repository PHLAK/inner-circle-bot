<?php

namespace Tests\Commands;

use App\Commands\Fallback;
use BotMan\BotMan\BotMan;
use Tests\TestCase;

class FallbackTest extends TestCase
{
    public function test_it_responds_with_a_random_reply(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('randomReply')->with([
            "I'm sorry Dave, I'm afraid I can't do that.",
            "I don't understand...",
            'Come again?',
            '¯\_(ツ)_/¯',
            'lol wut?',
            'NO U!',
            'Nope.',
            '???',
            '...',
            '🤔',
        ]);

        (new Fallback())($botman);
    }
}
