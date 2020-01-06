<?php

use App\Commands;
use App\Support\Helpers;

return [
    /** Telegram specific settings */
    'telegram' => [
        'token' => Helpers::env('TELEGRAM_TOKEN'),
    ],

    /** Array of command patterns mapped to their class names */
    'commands' => [
        'busy' => Commands\Busy::class,
        'dilbert(?: (.+))?' => Commands\Dilbert::class,
        'eightball(?: (.+))?' => Commands\Eightball::class,
        'ping' => Commands\Ping::class,
        'roll ([0-9]+)d([0-9]+)' => Commands\Roll::class,
        'slap {name}' => Commands\Slap::class,
        'xkcd(?: ([0-9]+))?' => Commands\XKCD::class,
    ],
];
