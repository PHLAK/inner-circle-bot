<?php

namespace Tests\Commands;

use App\Comic;
use App\Commands\MonkeyUser;
use App\Http\Clients\MonkeyUserClient;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use Tests\TestCase;

/** @covers \App\Commands\MonkeyUser */
class MonkeyUserTest extends TestCase
{
    public function test_it_can_fetch_the_latest_comic(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with(
            OutgoingMessage::create(
                '<strong>Test comic; please ignore</strong> • Some test alt-text'
            )->withAttachment(
                new Image('https://www.monkeyuser.com/assets/images/1986/123-test.png')
            )
        );

        $monkeyuser = $this->createMock(MonkeyUserClient::class);
        $monkeyuser->expects($this->once())->method('latest')->willReturn(
            new Comic(
                'Test comic; please ignore',
                'Some test alt-text',
                'https://www.monkeyuser.com/assets/images/1986/123-test.png',
                'https://www.monkeyuser.com/1986/test/'
            )
        );

        (new MonkeyUser)($botman, $monkeyuser);
    }

    public function test_it_returns_an_error_message_when_it_fails_to_fetch_a_comic(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with(
            "ERROR: Failed to fetch comic [418 I'm a teapot]"
        );

        $monkeyuser = $this->createMock(MonkeyUserClient::class);
        $monkeyuser->expects($this->once())->method('latest')->willThrowException(
            new ClientException("418 I'm a teapot", $this->createMock(Request::class))
        );

        (new MonkeyUser)($botman, $monkeyuser);
    }
}
