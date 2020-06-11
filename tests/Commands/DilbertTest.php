<?php

namespace Tests\Commands;

use App\Comic;
use App\Commands\Dilbert;
use App\Http\Clients\DilbertClient;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use Tests\TestCase;

/** @covers \App\Commands\Dilbert */
class DilbertTest extends TestCase
{
    public function test_it_can_fetch_the_latest_comic(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with(
            OutgoingMessage::create(
                '<strong>Latest comic; please ignore</strong>'
            )->withAttachment(
                new Image('http://assets.amuniversal.com/latest')
            )
        );

        $dilbert = $this->createMock(DilbertClient::class);
        $dilbert->expects($this->once())->method('latest')->willReturn(
            new Comic('Latest comic; please ignore', '', 'http://assets.amuniversal.com/latest', '')
        );

        (new Dilbert)($botman, null, $dilbert);
    }

    public function test_it_can_fetch_a_comic_by_date(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with(
            OutgoingMessage::create(
                '<strong>Test comic; please ignore</strong>'
            )->withAttachment(
                new Image('http://assets.amuniversal.com/test')
            )
        );

        $dilbert = $this->createMock(DilbertClient::class);
        $dilbert->expects($this->once())->method('byDate')->willReturn(
            new Comic('Test comic; please ignore', '', 'http://assets.amuniversal.com/test', '')
        );

        (new Dilbert)($botman, '1986-05-20', $dilbert);
    }

    public function test_it_can_fetch_a_random_comic(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with(
            OutgoingMessage::create(
                '<strong>Random comic; please ignore</strong>'
            )->withAttachment(
                new Image('http://assets.amuniversal.com/random')
            )
        );

        $dilbert = $this->createMock(DilbertClient::class);
        $dilbert->expects($this->once())->method('random')->willReturn(
            new Comic('Random comic; please ignore', '', 'http://assets.amuniversal.com/random', '')
        );

        (new Dilbert)($botman, 'random', $dilbert);
    }

    public function test_it_returns_an_error_message_when_it_fails_to_fetch_a_comic(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->willReturn(
            "ERROR: Failed to fetch comic [418 I'm a teapot]"
        );

        $dilbert = $this->createMock(DilbertClient::class);
        $dilbert->expects($this->once())->method('latest')->willThrowException(
            new ClientException("418 I'm a teapot", $this->createMock(Request::class))
        );

        (new Dilbert)($botman, null, $dilbert);
    }
}
