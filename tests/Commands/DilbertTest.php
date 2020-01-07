<?php

namespace Tests\Commands;

use App\Commands\Dilbert;
use BotMan\BotMan\BotMan;
use Tests\TestCase;

class DilbertTest extends TestCase
{
    public function test_it_can_respond_with_a_specific_comic(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with(
            'http://dilbert.com/strip/2005-07-06'
        );

        (new Dilbert())($botman, '2005-07-06');
    }

    public function test_it_can_respond_with_a_random_comic(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with(
            $this->matchesRegularExpression('/http:\/\/dilbert\.com\/strip\/\d{4}-\d{2}-\d{2}/')
        );

        (new Dilbert())($botman, 'random');
    }

    public function test_it_can_responds_with_an_error_when_date_is_out_of_range(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with('ERROR: Date out of range');

        (new Dilbert())($botman, '1986-05-20');
    }
}
