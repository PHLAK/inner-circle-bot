<?php

namespace App\Http\Clients;

use GuzzleHttp\Client;
use stdClass;

class XKCDClient
{
    /** @var Client The Guzzle HTTP client */
    protected $client;

    /**
     * Create a new XKCDClient object.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->client = new Client(array_replace_recursive([
            'base_uri' => 'https://xkcd.com',
            'connect_timeout' => 5,
            'timeout' => 10,
        ], $config));
    }

    /**
     * Fetch the latest comic.
     *
     * @return \stdClass
     */
    public function latest(): stdClass
    {
        $response = $this->client->get('info.0.json');

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Fetch a comic by ID.
     *
     * @param int $id
     *
     * @return \stdClass
     */
    public function byId(int $id): stdClass
    {
        $response = $this->client->get("{$id}/info.0.json");

        return json_decode($response->getBody()->getContents());
    }
}
