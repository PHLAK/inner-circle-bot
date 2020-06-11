<?php

namespace Tests\Commands;

use App\Commands\Coinflip;
use BotMan\BotMan\BotMan;
use Tests\TestCase;

/** @covers \App\Commands\Coinflip */
class CoinflipTest extends TestCase
{
    public function test_it_can_flip_a_coin(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with(
            $this->matchesRegularExpression('/<i>(?:heads|tails)<\/i>/'),
            ['parse_mode' => 'HTML']
        );

        (new Coinflip)($botman);
    }
}
