<?php

namespace Tests\Commands;

use App\Commands\Eightball;
use BotMan\BotMan\BotMan;
use Tests\TestCase;

class EightballTest extends TestCase
{
    public function test_it_respond_with_a_random_prediction(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('randomReply')->with([
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
        ]);

        (new Eightball)($botman);
    }
}
