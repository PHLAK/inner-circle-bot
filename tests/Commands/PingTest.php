<?php

namespace Tests\Commands;

use App\Commands\Ping;
use BotMan\BotMan\BotMan;
use Tests\TestCase;

class PingTest extends TestCase
{
    public function test_it_responds_to_a_ping(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with('pong');

        (new Ping)($botman);
    }
}
