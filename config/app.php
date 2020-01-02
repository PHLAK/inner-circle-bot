<?php

use App\Support\Helpers;

return [
    /** The bot's name (without the @) */
    'bot_name' => Helpers::env('BOT_NAME'),

    /** The endpoint hash */
    'endpoint_hash' => Helpers::env('ENDPOINT_HASH'),
];
