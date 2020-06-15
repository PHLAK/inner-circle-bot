<?php

namespace App\Commands;

use BotMan\BotMan\BotMan;

class Ping
{
    /** Handle the incoming request. */
    public function __invoke(BotMan $botman): void
    {
        $botman->reply('pong');
    }
}
