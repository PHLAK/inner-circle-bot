<?php

namespace App;

use Tests\TestCase;

class SMBCClientTest extends TestCase
{
    public function test_it_can_fetch_the_latest_comic(): void
    {
        $smbc = new SMBCClient($this->path('smbc.xml'));

        $this->assertEquals((object) [
            'title' => 'Test comic; please ignore',
            'alt_text' => 'Some test alt-text.',
            'image' => 'https://www.smbc-comics.com/comics/1234567890-19860520.png',
            'link' => 'https://www.smbc-comics.com/comic/test',
        ], $smbc->latest());
    }
}
