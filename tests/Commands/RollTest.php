<?php

namespace Tests\Commands;

use App\Commands\Roll;
use BotMan\BotMan\BotMan;
use Tests\TestCase;

class RollTest extends TestCase
{
    public function test_it_can_roll_a_single_die(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->exactly(2))->method('reply')->withConsecutive([
            $this->callback(function (string $argument): bool {
                return (bool) preg_match('/Rolling 1 × 100 sided die.../', $argument);
            })
        ], [
            $this->callback(function (string $argument): bool {
                return (bool) preg_match('/\[ (\d+) \] Total: \1/', $argument);
            })
        ]);

        (new Roll())($botman, 1, 100);
    }

    public function test_it_can_roll_multiple_dice(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->exactly(2))->method('reply')->withConsecutive([
            $this->matchesRegularExpression('/Rolling 2 × 20 sided dice.../')
        ], [
            $this->matchesRegularExpression('/\[ \d+, \d+ \] Total: \d+/')
        ]);

        (new Roll())($botman, 2, 20);
    }

    public function test_it_limits_the_number_of_dice_rolled(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with(
            'I am not able to hold that many dice at once'
        );

        (new Roll())($botman, 301, 20);
    }

    public function test_it_limits_the_maximum_die_value(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with(
            'I seem to have misplaced my 1000000000 sided die'
        );

        (new Roll())($botman, 1, 1000000000);
    }
}
