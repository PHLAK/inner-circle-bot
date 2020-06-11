<?php

namespace Tests\Http\Clients;

use App\Http\Clients\SMBCClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

/** @covers \App\Http\Clients\SMBCClient */
class SMBCClientTest extends TestCase
{
    public function test_it_can_fetch_the_latest_comic(): void
    {
        $comic = $this->mockSMBCClient()->latest();

        $this->assertEquals('Test comic; please ignore', $comic->title);
        $this->assertEquals('Some test alt-text.', $comic->altText);
        $this->assertEquals('https://www.smbc-comics.com/comics/1234567890-19860520.png', $comic->imageUrl);
        $this->assertEquals('https://www.smbc-comics.com/comic/test', $comic->sourceUrl);
    }

    /**
     * Create a mocked SMBCClient object.
     *
     * @param array $responses
     *
     * @return \App\Http\Clients\SMBCClient
     */
    protected function mockSMBCClient(array $responses = null): SMBCClient
    {
        return new SMBCClient([
            'handler' => HandlerStack::create(
                new MockHandler($responses ?? [
                    new Response(200, [], file_get_contents(
                        $this->path('smbc.xml')
                    ))
                ])
            )
        ]);
    }
}
