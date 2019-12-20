<?php

namespace App\Commands;

use BotMan\BotMan\BotMan;

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
        $botman->reply(
            sprintf('Rolling %d × %d sided %s...', $dice, $sides, $dice > 1 ? 'dice' : 'die')
        );

        for ($i = 1; $i <= $dice; ++$i) {
            $botman->reply((string) rand(1, $sides));
        }
    }
}
