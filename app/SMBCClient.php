<?php

namespace App;

use SimpleXMLElement;
use stdClass;

class SMBCClient
{
    /** @var string The SMBC RSS feed URL */
    protected $rssUrl;

    /**
     * Create a new SMBCClient object.
     *
     * @param string $rssUrl
     */
    public function __construct(string $rssUrl = 'https://www.smbc-comics.com/comic/rss')
    {
        $this->rssUrl = $rssUrl;
    }

    /**
     * Fetch the latest comic.
     *
     * @return \stdClass
     */
    public function latest(): stdClass
    {
        $xml = new SimpleXMLElement(file_get_contents($this->rssUrl));
        $comic = $xml->channel->item[0];

        preg_match('/^Saturday Morning Breakfast Cereal - (.*)$/', $comic->title, $matches);
        [, $title] = $matches;

        preg_match('/<img src="(.*)" \/>.*<p>Hovertext:(?:<br\/>)(.*)<\/p>/', $comic->description, $matches);
        [, $imageUrl, $altText] = $matches;

        return (object) [
            'title' => $title,
            'alt_text' => $altText,
            'image' => $imageUrl,
            'link' => $comic->link,
        ];
    }
}
