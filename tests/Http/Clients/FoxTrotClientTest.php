<?php

namespace Tests\Http\Clients;

use App\Http\Clients\FoxTrotClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

/** @covers \App\Http\Clients\FoxTrotClient */
class FoxTrotClientTest extends TestCase
{
    public function test_it_can_fetch_the_latest_comic(): void
    {
        $comic = $this->mockFoxTrotClient()->latest();

        $this->assertEquals('Test comic; please ignore', $comic->title);
        $this->assertEquals('Some test alt-text.', $comic->altText);
        $this->assertEquals('https://foxtrot.com/comics/test_comic.png', $comic->imageUrl);
        $this->assertEquals('https://foxtrot.com/comic/test', $comic->sourceUrl);
    }

    /** Create a mocked FoxTrotClient object. */
    protected function mockFoxTrotClient(?array $responses = null): FoxTrotClient
    {
        return new FoxTrotClient([
            'handler' => HandlerStack::create(
                new MockHandler($responses ?? [
                    new Response(200, [], file_get_contents($this->path('foxtrot.xml'))),
                    new Response(200, [], file_get_contents($this->path('foxtrot.html'))),
                ])
            )
        ]);
    }
}
