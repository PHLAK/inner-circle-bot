<?php

use App\Commands;

return [
    /** Telegram specific settings */
    'telegram' => [
        'token' => 'TEST_TELEGRAM_TOKEN',
    ],

    /** Array of command patterns mapped to their class names */
    'commands' => [
        'ping' => Commands\Ping::class,
    ],
];
