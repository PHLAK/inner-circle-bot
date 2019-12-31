<?php

use App\Support\Helpers;

return [
    /** Telegram specific settings */
    'telegram' => [
        'token' => Helpers::env('TELEGRAM_TOKEN'),
    ],
];
