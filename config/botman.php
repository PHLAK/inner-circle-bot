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
        'coinflip' => Commands\Coinflip::class,
        'dilbert(?: (.+))?' => Commands\Dilbert::class,
        'eightball(?: (.+))?' => Commands\Eightball::class,
        'explosm(?: ([0-9]+))?' => Commands\Explosm::class,
        'ping' => Commands\Ping::class,
        'roll ([0-9]+)d([0-9]+)' => Commands\Roll::class,
        'slap {name}' => Commands\Slap::class,
        'smbc' => Commands\SMBC::class,
        'xkcd(?: ([0-9]+))?' => Commands\XKCD::class,
    ],
];
