<?php

namespace App;

class Comic
{
    protected string $title;
    protected string $altText;
    protected string $imageUrl;
    protected string $sourceUrl;

    /** Create a new Comic object. */
    public function __construct(
        string $title,
        string $altText,
        string $imageUrl,
        string $sourceUrl
    ) {
        $this->title = $title;
        $this->altText = $altText;
        $this->imageUrl = $imageUrl;
        $this->sourceUrl = $sourceUrl;
    }

    /** Get a protected property. */
    public function __get(string $name)
    {
        return $this->{$name};
    }
}
