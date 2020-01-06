<?php

namespace App;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class XKCDClientTest extends TestCase
{
    public function test_it_can_fetch_the_latest_comic(): void
    {
        $xkcd = $this->mockXKCDCLient();

        $comic = $xkcd->latest();

        $this->assertEquals(1337, $comic->num);
        $this->assertEquals('Test title; please ignore', $comic->safe_title);
        $this->assertEquals('This is the alt text.', $comic->alt);
        $this->assertEquals('https://imgs.xkcd.com/comics/example.png', $comic->img);
    }

    public function test_it_can_fetch_a_comic_by_id(): void
    {
        $xkcd = $this->mockXKCDCLient();

        $comic = $xkcd->byId(1337);

        $this->assertEquals(1337, $comic->num);
        $this->assertEquals('Test title; please ignore', $comic->safe_title);
        $this->assertEquals('This is the alt text.', $comic->alt);
        $this->assertEquals('https://imgs.xkcd.com/comics/example.png', $comic->img);
    }

    protected function mockXKCDCLient(array $responses = null): XKCDClient
    {
        return new XKCDClient([
            'handler' => HandlerStack::create(
                new MockHandler($responses ?? [
                    new Response(200, [], json_encode([
                        'month' => '5',
                        'num' => 1337,
                        'link' => '',
                        'year' => '1986',
                        'news' => '',
                        'safe_title' => 'Test title; please ignore',
                        'transcript' => '',
                        'alt' => 'This is the alt text.',
                        'img' => 'https://imgs.xkcd.com/comics/example.png',
                        'title' => 'Test title; please ignore',
                        'day' => '20',
                    ]))
                ])
            )
        ]);
    }
}
