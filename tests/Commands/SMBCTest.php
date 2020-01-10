<?php

namespace Tests\Commands;

use App\Commands\SMBC;
use App\SMBCClient;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use Tests\TestCase;

class SMBCTest extends TestCase
{
    public function test_it_can_fetch_the_latest_comic(): void
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
            (object) [
                'title' => 'Test comic; please ignore',
                'alt_text' => 'Some test alt-text',
                'image' => 'https://www.smbc-comics.com/comics/1234567890-19860520.png',
                'link' => 'https://www.smbc-comics.com/comics/test',
            ]
        );

        (new SMBC())($botman, $smbc);
    }
}
