<?php

namespace App;

class Comic
{
    /** @var string The comic's title */
    protected $title;

    /** @var string The comic's alt/hover text */
    protected $altText;

    /** @var string The comic's image URL */
    protected $imageUrl;

    /** @var string The comic's source URL */
    protected $sourceUrl;

    /**
     * Create a new Comic object.
     *
     * @param string $title
     * @param string $altText
     * @param string $imageUrl
     * @param string $sourceUrl
     */
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

    /**
     * Get a protected property.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->{$name};
    }
}
