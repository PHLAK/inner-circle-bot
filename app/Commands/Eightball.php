<?php

namespace App\Commands;

use BotMan\BotMan\BotMan;

class Eightball
{
    /** @const Array of possible answers */
    public const ANSWERS = [
        'It is certain',
        'It is decidedly so',
        'Without a doubt',
        'Yes definitely',
        'You may rely on it',
        'As I see it, yes',
        'Most likely',
        'Outlook good',
        'Yes',
        'Signs point to yes',
        'Reply hazy try again',
        'Ask again later',
        'Better not tell you now',
        'Cannot predict now',
        'Concentrate and ask again',
        "Don't count on it",
        'My reply is no',
        'My sources say no',
        'Outlook not so good',
        'Very doubtful'
    ];

    /** Handle the incoming request. */
    public function __invoke(BotMan $botman): void
    {
        $botman->randomReply(self::ANSWERS);
    }
}
