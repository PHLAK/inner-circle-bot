<?php

namespace App\Commands;

use BotMan\BotMan\BotMan;
use Tightenco\Collect\Support\Collection;

class Eightball
{
    /** @const Array of possible answers */
    protected const ANSWERS = [
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

    /**
     * Handle the incoming request.
     *
     * @param \BotMan\BotMan\BotMan $botman
     * @param string                $question
     *
     * @return void
     */
    public function __invoke(BotMan $botman, string $question)
    {
        $botman->reply(Collection::make(self::ANSWERS)->random());
    }
}
