<?php

namespace Tests\Commands;

use App\Commands\Fallback;
use BotMan\BotMan\BotMan;
use Tests\TestCase;

/** @covers \App\Commands\Fallback */
class FallbackTest extends TestCase
{
    public function test_it_responds_with_a_random_reply(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('randomReply')->with(Fallback::REPLIES);

        (new Fallback)($botman);
    }
}
