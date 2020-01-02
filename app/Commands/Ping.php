<?php

namespace App\Commands;

use BotMan\BotMan\BotMan;

class Ping
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
        $botman->reply('pong');
    }
}
