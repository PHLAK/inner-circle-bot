<?php

namespace Tests\Commands;

use App\Comic;
use App\Commands\FoxTrot;
use App\Http\Clients\FoxTrotClient;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

/** @covers \App\Commands\FoxTrot */
class FoxTrotTest extends TestCase
{
    /** @test */
    public function it_can_fetch_the_latest_comic(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with(
            OutgoingMessage::create(
                '<strong>Test comic; please ignore</strong>'
            )->withAttachment(
                new Image('https://foxtrot.com/comics/test_comic.png')
            )
        );

        $foxtrot = $this->createMock(FoxTrotClient::class);
        $foxtrot->expects($this->once())->method('latest')->willReturn(
            new Comic('Test comic; please ignore', 'Some test alt-text', 'https://foxtrot.com/comics/test_comic.png', '')
        );

        (new FoxTrot)($botman, $foxtrot);
    }

    /** @test */
    public function it_returns_an_error_message_when_it_fails_to_fetch_a_comic(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with(
            "ERROR: Failed to fetch comic [418 I'm a teapot]"
        );

        $foxtrot = $this->createMock(FoxTrotClient::class);
        $foxtrot->expects($this->once())->method('latest')->willThrowException(
            new ClientException(
                "418 I'm a teapot",
                $this->createMock(Request::class),
                $this->createMock(Response::class)
            )
        );

        (new FoxTrot)($botman, $foxtrot);
    }
}
