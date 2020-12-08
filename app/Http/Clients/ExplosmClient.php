<?php

namespace App\Http\Clients;

use App\Comic;
use GuzzleHttp\Client;

class ExplosmClient
{
    protected Client $client;

    /** Create a new ExplosmClient object. */
    public function __construct(array $config = [])
    {
        $this->client = new Client(array_replace_recursive([
            'base_uri' => 'http://explosm.net',
            'connect_timeout' => 5,
            'timeout' => 10,
        ], $config));
    }

    /** Fetch the latest comic. */
    public function latest(): Comic
    {
        $html = (string) $this->client->get('comics/latest')->getBody();

        return new Comic(
            $this->extractTitle($html),
            $this->extractDescription($html),
            $this->extractImageUrl($html),
            $this->extractSourceUrl($html)
        );
    }

    /** Fetch a comic by ID. */
    public function byId(int $id): Comic
    {
        $html = (string) $this->client->get(
            sprintf('comics/%d', $id)
        )->getBody();

        return new Comic(
            $this->extractTitle($html),
            $this->extractDescription($html),
            $this->extractImageUrl($html),
            $this->extractSourceUrl($html)
        );
    }

    /** Extract the comcic's title from the HTML. */
    protected function extractTitle(string $html): string
    {
        preg_match('/<meta\s*property="og:title"\s*content="(?<title>.*)"\s*\/>?/', $html, $matches);

        return $matches['title'];
    }

    /** Extract the comcic's description from the HTML. */
    protected function extractDescription(string $html): string
    {
        preg_match('/<meta\s*property="og:description"\s*content="(?<description>.*)"\s*\/?>/', $html, $matches);

        return $matches['description'];
    }

    /** Extract the comic's image URL from the HTML. */
    protected function extractImageUrl(string $html): string
    {
        preg_match('/<meta\s*property="og:image"\s*content="(?<image_url>.*)"\s*\/?>/', $html, $matches);

        return $matches['image_url'];
    }

    /** Extract the comic's source URL from the HTML. */
    protected function extractSourceUrl(string $html): string
    {
        preg_match('/<meta\s*property="og:url"\s*content="(?<source_url>.*)"\s*\/?>/', $html, $matches);

        return $matches['source_url'];
    }
}
