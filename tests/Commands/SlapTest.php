<?php

namespace Tests\Commands;

use App\Commands\Slap;
use BotMan\BotMan\BotMan;
use Tests\TestCase;

/** @covers \App\Commands\Slap */
class SlapTest extends TestCase
{
    /** @test */
    public function it_can_slap_someone_with_a_random_object(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with(
            $this->matchesRegularExpression(
                sprintf('/<i>slaps Arthur Dent around a bit with (?:%s)<\/i>/', implode('|', Slap::OBJECTS))
            ),
            ['parse_mode' => 'HTML']
        );

        (new Slap)($botman, 'Arthur Dent');
    }
}
