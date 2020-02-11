<?php

namespace App\Http\Clients;

use Carbon\Carbon;
use GuzzleHttp\Client;
use stdClass;

class CoinbaseClient
{
    /** @var Client The Guzzle HTTP client */
    protected $client;

    /**
     * Create a new CoinbaseClient object.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->client = new Client((array) array_replace_recursive([
            'base_uri' => 'https://api.coinbase.com/v2/',
            'connect_timeout' => 5,
            'timeout' => 10,
        ], $config));
    }

    /**
     * Fetch the current price.
     *
     * @return \stdClass
     */
    public function currentPrice(): stdClass
    {
        $response = $this->client->get('prices/BTC-USD/spot');

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Fetch the price from a specific date// ...
     *
     * @param Carbon $date
     *
     * @return \stdClass
     */
    public function priceOn(Carbon $date): stdClass
    {
        $response = $this->client->get(
            sprintf('prices/BTC-USD/spot?date=%s', $date->format('Y-m-d'))
        );

        return json_decode($response->getBody()->getContents());
    }
}
