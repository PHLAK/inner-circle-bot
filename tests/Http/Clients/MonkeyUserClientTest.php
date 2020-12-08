<?php

namespace Tests\Http\Clients;

use App\Http\Clients\MonkeyUserClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

/** @covers \App\Http\Clients\MonkeyUserClient */
class MonkeyUserClientTest extends TestCase
{
    /** @test */
    public function it_can_fetch_the_latest_comic(): void
    {
        $comic = $this->mockMonkeyUserClient()->latest();

        $this->assertEquals('Test comic; please ignore', $comic->title);
        $this->assertEquals('Some test alt-text.', $comic->altText);
        $this->assertEquals('https://www.monkeyuser.com/assets/images/1986/123-test.png', $comic->imageUrl);
        $this->assertEquals('https://www.monkeyuser.com/1986/test/', $comic->sourceUrl);
    }

    /** Create a mocked MonkeyUserClient object. */
    protected function mockMonkeyUserClient(?array $responses = null): MonkeyUserClient
    {
        return new MonkeyUserClient([
            'handler' => HandlerStack::create(
                new MockHandler($responses ?? [
                    new Response(200, [], file_get_contents(
                        $this->path('monkeyuser.xml')
                    )),
                ])
            ),
        ]);
    }
}
