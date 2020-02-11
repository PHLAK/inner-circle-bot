<?php

namespace Tests\Http\Clients;

use App\Http\Clients\CoinbaseClient;
use Carbon\Carbon;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

class CoinbaseClientTest extends TestCase
{
    public function test_it_can_fetch_the_current_price(): void
    {
        $btc = $this->mockCoinbaseClient()->currentPrice();

        $this->assertEquals($btc->data->base, 'BTC');
        $this->assertEquals($btc->data->currency, 'USD');
        $this->assertEquals($btc->data->amount, 1337.42);
    }

    public function test_it_can_fetch_the_price_from_a_specific_date(): void
    {
        $btc = $this->mockCoinbaseClient()->priceOn(
            Carbon::parse('1986-05-20')
        );

        $this->assertEquals($btc->data->amount, 1337.42);
    }

    /**
     * Create a mocked CoinbaseClient object.
     *
     * @param array $responses
     *
     * @return \App\Http\Clients\CoinbaseClient
     */
    protected function mockCoinbaseClient(array $responses = null): CoinbaseClient
    {
        return new CoinbaseClient([
            'handler' => HandlerStack::create(
                new MockHandler($responses ?? [
                    new Response(200, [], json_encode([
                        'data' => [
                            'base' => 'BTC',
                            'currency' => 'USD',
                            'amount' => 1337.42,
                        ]
                    ]))
                ])
            )
        ]);
    }
}
