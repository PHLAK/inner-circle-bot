<?php

namespace Tests\Commands;

use App\Commands\Eightball;
use BotMan\BotMan\BotMan;
use Tests\TestCase;

/** @covers \App\Commands\Eightball */
class EightballTest extends TestCase
{
    public function test_it_respond_with_a_random_prediction(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('randomReply')->with(Eightball::ANSWERS);

        (new Eightball)($botman);
    }
}
