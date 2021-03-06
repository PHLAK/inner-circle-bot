<?php

namespace Tests\Commands;

use App\Comic;
use App\Commands\SMBC;
use App\Http\Clients\SMBCClient;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use Slim\Psr7\Response;
use Tests\TestCase;

/** @covers \App\Commands\SMBC */
class SMBCTest extends TestCase
{
    /** @test */
    public function it_can_fetch_the_latest_comic(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with(
            OutgoingMessage::create(
                '<strong>Test comic; please ignore</strong> • Some test alt-text'
            )->withAttachment(
                new Image('https://www.smbc-comics.com/comics/1234567890-19860520.png')
            )
        );

        $smbc = $this->createMock(SMBCClient::class);
        $smbc->expects($this->once())->method('latest')->willReturn(
            new Comic(
                'Test comic; please ignore',
                'Some test alt-text',
                'https://www.smbc-comics.com/comics/1234567890-19860520.png',
                'https://www.smbc-comics.com/comics/test'
            )
        );

        (new SMBC)($botman, $smbc);
    }

    /** @test */
    public function it_returns_an_error_message_when_it_fails_to_fetch_a_comic(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with(
            "ERROR: Failed to fetch comic [418 I'm a teapot]"
        );

        $smbc = $this->createMock(SMBCClient::class);
        $smbc->expects($this->once())->method('latest')->willThrowException(
            new ClientException(
                "418 I'm a teapot",
                $this->createMock(Request::class),
                $this->createMock(Response::class)
            )
        );

        (new SMBC)($botman, $smbc);
    }
}
