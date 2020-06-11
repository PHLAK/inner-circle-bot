<?php

namespace Tests\Http\Clients;

use App\Http\Clients\ExplosmClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

/** @covers \App\Http\Clients\ExplosmClient */
class ExplosmClientTest extends TestCase
{
    public function test_it_can_fetch_the_latest_comic(): void
    {
        $comic = $this->mockExplosmClient()->latest();

        $this->assertEquals('Cyanide & Happiness (Explosm.net)', $comic->title);
        $this->assertEquals('A Cyanide & Happiness Comic', $comic->altText);
        $this->assertEquals('http://files.explosm.net/comics/Arthur/test.png', $comic->imageUrl);
        $this->assertEquals('http://explosm.net/comics/1337/', $comic->sourceUrl);
    }

    public function test_it_can_fetch_a_comic_by_id(): void
    {
        $comic = $this->mockExplosmClient()->byId(1337);

        $this->assertEquals('Cyanide & Happiness (Explosm.net)', $comic->title);
        $this->assertEquals('A Cyanide & Happiness Comic', $comic->altText);
        $this->assertEquals('http://files.explosm.net/comics/Arthur/test.png', $comic->imageUrl);
        $this->assertEquals('http://explosm.net/comics/1337/', $comic->sourceUrl);
    }

    /**
     * Create a mocked ExplosmClient object.
     *
     * @param array $responses
     *
     * @return \App\Http\Clients\ExplosmClient
     */
    protected function mockExplosmClient(array $responses = null): ExplosmClient
    {
        return new ExplosmClient([
            'handler' => HandlerStack::create(
                new MockHandler($responses ?? [
                    new Response(200, [], file_get_contents(
                        $this->path('explosm.html')
                    ))
                ])
            )
        ]);
    }
}
