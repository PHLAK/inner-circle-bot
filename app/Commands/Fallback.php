<?php

namespace App\Commands;

use BotMan\BotMan\BotMan;

class Fallback
{
    /** @const Array of possible replies */
    protected const REPLIES = [
        "I'm sorry Dave, I'm afraid I can't do that.",
        "I don't understand...",
        'Come again?',
        '¯\_(ツ)_/¯',
        'lol wut?',
        'NO U!',
        'Nope.',
        '???',
        '...',
        '🤔',
    ];

    /** Run the command. */
    public function __invoke(BotMan $botman): void
    {
        $botman->randomReply(self::REPLIES);
    }
}
