<?php

namespace Tests\Commands;

use App\Comic;
use App\Commands\Explosm;
use App\Http\Clients\ExplosmClient;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

/** @covers \App\Commands\Explosm */
class ExplosmTest extends TestCase
{
    /** @test */
    public function it_can_fetch_the_latest_comic(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with(
            OutgoingMessage::create(
                '<strong>Test comic; please ignore</strong>'
            )->withAttachment(
                new Image('http://files.explosm.net/comics/Arthur/test.png')
            )
        );

        $explosm = $this->createMock(ExplosmClient::class);
        $explosm->expects($this->once())->method('latest')->willReturn(
            new Comic(
                'Test comic; please ignore',
                'Some test alt-text',
                'http://files.explosm.net/comics/Arthur/test.png',
                'http://explosm.net/comics/1337/'
            )
        );

        (new Explosm)($botman, null, $explosm);
    }

    /** @test */
    public function it_can_fetch_a_comic_by_id(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with(
            OutgoingMessage::create(
                '<strong>Test comic; please ignore</strong>'
            )->withAttachment(
                new Image('http://files.explosm.net/comics/Arthur/test.png')
            )
        );

        $explosm = $this->createMock(ExplosmClient::class);
        $explosm->expects($this->once())->method('byId')->willReturn(
            new Comic(
                'Test comic; please ignore',
                'Some test alt-text',
                'http://files.explosm.net/comics/Arthur/test.png',
                'http://explosm.net/comics/1337/'
            )
        );

        (new Explosm)($botman, 1337, $explosm);
    }

    /** @test */
    public function it_returns_an_error_message_when_it_fails_to_fetch_a_comic(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with(
            "ERROR: Failed to fetch comic [418 I'm a teapot]"
        );

        $explosm = $this->createMock(ExplosmClient::class);
        $explosm->expects($this->once())->method('latest')->willThrowException(
            new ClientException(
                "418 I'm a teapot",
                $this->createMock(Request::class),
                $this->createMock(Response::class)
            )
        );

        (new Explosm)($botman, null, $explosm);
    }
}
