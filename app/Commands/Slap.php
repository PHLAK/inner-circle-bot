<?php

namespace App\Commands;

use BotMan\BotMan\BotMan;
use Tightenco\Collect\Support\Collection;

class Slap
{
    /** @const Array of objects */
    public const OBJECTS = [
        'a french baguette',
        'a large trout',
        'a soggy noodle',
        'a strip of bacon',
        'a large waffle',
        'an iron gauntlet',
        'string cheese',
        'the back of their hand',
    ];

    protected Collection $objects;

    /** Create a new Slap object. */
    public function __construct()
    {
        $this->objects = new Collection(self::OBJECTS);
    }

    /** Handle the incoming request. */
    public function __invoke(BotMan $botman, string $name): void
    {
        $botman->reply(sprintf(
            '<i>slaps %s around a bit with %s</i>', $name, $this->objects->random()
        ), ['parse_mode' => 'HTML']);
    }
}
