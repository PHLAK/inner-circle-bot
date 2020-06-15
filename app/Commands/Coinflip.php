<?php

namespace App\Commands;

use BotMan\BotMan\BotMan;
use Tightenco\Collect\Support\Collection;

class Coinflip
{
    /** Handle the incoming request. */
    public function __invoke(BotMan $botman): void
    {
        $botman->reply(
            sprintf('<i>%s</i>', Collection::make(['heads', 'tails'])->random()),
            ['parse_mode' => 'HTML']
        );
    }
}
