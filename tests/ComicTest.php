<?php

namespace Tests;

use App\Comic;

class ComicTest extends TestCase
{
    public function test_it_can_be_instantiated(): void
    {
        $comic = new Comic(
            'Test title; please ignore',
            'Some alt text...',
            'https://example.com/images/123.png',
            'https://example.com/comic/123'
        );

        $this->assertEquals('Test title; please ignore', $comic->title);
        $this->assertEquals('Some alt text...', $comic->altText);
        $this->assertEquals('https://example.com/images/123.png', $comic->imageUrl);
        $this->assertEquals('https://example.com/comic/123', $comic->sourceUrl);
    }
}
