<?php

namespace Tests\Commands;

use App\Commands\Busy;
use BotMan\BotMan\BotMan;
use Tests\TestCase;

/** @covers \App\Commands\Busy */
class BusyTest extends TestCase
{
    public function test_it_respond_with_a_busy_message(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with(
            $this->callback(function (string $parameter): bool {
                preg_match('/(?<verb>[\w-]+) (?<adjective>[\w-]+)? (?<noun>[\w-]+)/', $parameter, $matches);
                extract($matches);

                if (! in_array($verb, Busy::VERBS)) {
                    return false;
                }

                if (! in_array($adjective, Busy::ADJECTIVES)) {
                    return false;
                }

                if (! in_array($noun, Busy::NOUNS)) {
                    return false;
                }

                return true;
            })
        );

        (new Busy)($botman);
    }
}
