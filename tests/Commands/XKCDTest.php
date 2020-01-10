<?php

namespace Tests\Commands;

use App\Commands\XKCD;
use App\XKCDClient;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use Tests\TestCase;

class XKCDTest extends TestCase
{
    public function test_it_can_fetch_the_latest_comic(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with(
            OutgoingMessage::create(
                '<strong>Test comic; please ignore</strong> • Some test alt-text'
            )->withAttachment(
                new Image('https://imgs.xkcd.com/comics/test_comic.png')
            )
        );

        $xkcd = $this->createMock(XKCDClient::class);
        $xkcd->expects($this->once())->method('latest')->willReturn(
            (object) [
                'month' => '5',
                'num' => 2253,
                'link' => '',
                'year' => '1986',
                'news' => '',
                'safe_title' => 'Test comic; please ignore',
                'transcript' => '',
                'alt' => 'Some test alt-text',
                'img' => 'https://imgs.xkcd.com/comics/test_comic.png',
                'title' => 'Test comic; please ignore',
                'day' => '20',
            ]
        );

        (new XKCD())($botman, null, $xkcd);
    }
}
