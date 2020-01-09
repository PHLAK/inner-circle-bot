<?php

namespace App\Commands;

use BotMan\BotMan\BotMan;
use Tightenco\Collect\Support\Collection;

class Roll
{
    /**
     * Handle the incoming request.
     *
     * @param \BotMan\BotMan\BotMan $botman
     * @param int                   $dice
     * @param int                   $sides
     *
     * @return void
     */
    public function __invoke(BotMan $botman, int $dice, int $sides)
    {
        if ($dice > 9999) {
            $botman->reply('I am not able to hold that many dice at once');

            return;
        }

        if ($sides > 999999999) {
            $botman->reply(
                sprintf('I seem to have misplaced my %d sided die', $sides)
            );

            return;
        }

        $botman->reply(
            sprintf('Rolling %d × %d sided %s...', $dice, $sides, $dice > 1 ? 'dice' : 'die')
        );

        $rolls = new Collection();
        for ($i = 1; $i <= $dice; ++$i) {
            $rolls->add(rand(1, $sides));
        }

        $botman->reply(
            sprintf('[ %s ] Total: %d', $rolls->implode(', '), $rolls->sum())
        );
    }
}
