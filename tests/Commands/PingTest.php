<?php

namespace Tests\Commands;

use App\Commands\Ping;
use BotMan\BotMan\BotMan;
use Tests\TestCase;

/** @covers \App\Commands\Ping */
class PingTest extends TestCase
{
    /** @test */
    public function it_responds_to_a_ping(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with('pong');

        (new Ping)($botman);
    }
}
