<?php

namespace App\Commands;

use BotMan\BotMan\BotMan;
use Tightenco\Collect\Support\Collection;

class Slap
{
    /** @const Array of objects */
    public const OBJECTS = [
        'a big black cock',
        'an iron gauntlet',
        'a large trout',
        'a soggy noodle',
    ];

    /** @var Collection */
    protected $objects;

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
