<?php

namespace App\Http\Clients;

use App\Comic;
use GuzzleHttp\Client;
use SimpleXMLElement;

class SMBCClient
{
    protected Client $client;

    /** Create a new SMBCClient object. */
    public function __construct(array $config = [])
    {
        $this->client = new Client(array_replace_recursive([
            'base_uri' => 'https://www.smbc-comics.com',
            'connect_timeout' => 5,
            'timeout' => 10,
        ], $config));
    }

    /** Fetch the latest comic. */
    public function latest(): Comic
    {
        $xml = new SimpleXMLElement(
            (string) $this->client->get('comic/rss')->getBody()
        );

        $comic = $xml->channel->item[0];

        return new Comic(
            $this->extractTitle($comic),
            $this->extractAltText($comic),
            $this->extractImageUrl($comic),
            $comic->link
        );
    }

    /** Extract the title from a comic XML object. */
    protected function extractTitle(SimpleXMLElement $comic): string
    {
        preg_match('/^Saturday Morning Breakfast Cereal - (?<title>.*)$/', $comic->title, $matches);

        return $matches['title'];
    }

    /** Extract the alt text from a comic XML object. */
    protected function extractAltText(SimpleXMLElement $comic): string
    {
        preg_match('/<p>Hovertext:(?:<br\/>)(?<alt_text>.*)<\/p>/', $comic->description, $matches);

        return $matches['alt_text'];
    }

    /** Extract the image URL from a comic XML object. */
    protected function extractImageUrl(SimpleXMLElement $comic): string
    {
        preg_match('/<img src="(?<image_url>.*)" \/>/', $comic->description, $matches);

        return $matches['image_url'];
    }
}
