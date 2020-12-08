<?php

namespace App\Http\Clients;

use App\Comic;
use GuzzleHttp\Client;
use SimpleXMLElement;

class FoxTrotClient
{
    protected Client $client;

    /** Create a new FoxTrotClient object. */
    public function __construct(array $config = [])
    {
        $this->client = new Client(array_replace_recursive([
            'base_uri' => 'https://foxtrot.com',
            'connect_timeout' => 5,
            'timeout' => 10,
        ], $config));
    }

    /** Fetch the latest comic. */
    public function latest(): Comic
    {
        $xml = new SimpleXMLElement(
            (string) $this->client->get('feed/')->getBody()
        );

        $html = (string) $this->client->get(
            (string) $xml->channel->item[0]->guid
        )->getBody();

        return new Comic(
            $this->extractTitle($html),
            $this->extractAltText($html),
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
    protected function extractAltText(string $html): string
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
