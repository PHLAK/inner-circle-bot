<?php

namespace App\Http\Clients;

use GuzzleHttp\Client;
use stdClass;

class XKCDClient
{
    protected Client $client;

    /** Create a new XKCDClient object. */
    public function __construct(array $config = [])
    {
        $this->client = new Client(array_replace_recursive([
            'base_uri' => 'https://xkcd.com',
            'connect_timeout' => 5,
            'timeout' => 10,
        ], $config));
    }

    /** Fetch the latest comic. */
    public function latest(): stdClass
    {
        $response = $this->client->get('info.0.json');

        return json_decode($response->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);
    }

    /** Fetch a comic by ID. */
    public function byId(int $id): stdClass
    {
        $response = $this->client->get(sprintf('%s/info.0.json', $id));

        return json_decode($response->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);
    }
}
