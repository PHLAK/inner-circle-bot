<?php

namespace App\Commands;

use BotMan\BotMan\BotMan;
use Tightenco\Collect\Support\Collection;

class Coinflip
{
    /**
     * Handle the incoming request.
     *
     * @param \BotMan\BotMan\BotMan $botman
     *
     * @return void
     */
    public function __invoke(BotMan $botman)
    {
        $botman->reply(
            sprintf('<i>%s</i>', Collection::make(['heads', 'tails'])->random()),
            ['parse_mode' => 'HTML']
        );
    }
}
