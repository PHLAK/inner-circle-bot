<?php

namespace Tests\Commands;

use App\Commands\Slap;
use BotMan\BotMan\BotMan;
use Tests\TestCase;

/** @covers \App\Commands\Slap */
class SlapTest extends TestCase
{
    public function test_it_can_slap_someone_with_a_random_object(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with(
            $this->matchesRegularExpression(
                '/<i>slaps Arthur Dent around a bit with (?:a big black cock|an iron gauntlet|a large trout|a soggy noodle)<\/i>/'
            ),
            ['parse_mode' => 'HTML']
        );

        (new Slap)($botman, 'Arthur Dent');
    }
}
