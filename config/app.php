<?php

use App\Commands;
use App\Factories;

return [
    /** Path to base application folder */
    'base_path' => dirname(__DIR__),

    /** The bot's name (without the @) */
    'bot_name' => DI\env('BOT_NAME', 'TheInnerCircleBot'),

    /** The Telegram API token */
    'telegram_token' => DI\env('TELEGRAM_TOKEN'),

    /** BotMan specific configuration */
    'botman_config' => [
        'telegram' => [
            'token' => DI\get('telegram_token'),
        ],
    ],

    /** Array of command patterns mapped to their class names */
    'commands' => [
        'btc(?: (.+))?' => Commands\Btc::class,
        'busy' => Commands\Busy::class,
        'coinflip' => Commands\Coinflip::class,
        'dilbert(?: (.+))?' => Commands\Dilbert::class,
        'eightball(?: (.+))?' => Commands\Eightball::class,
        'explosm(?: ([0-9]+))?' => Commands\Explosm::class,
        'monkeyuser' => Commands\MonkeyUser::class,
        'ping' => Commands\Ping::class,
        'roll ([0-9]+)d([0-9]+)' => Commands\Roll::class,
        'slap {name}' => Commands\Slap::class,
        'smbc' => Commands\SMBC::class,
        'xkcd(?: ([0-9]+))?' => Commands\XKCD::class,
    ],

    /** Container definitions */
    BotMan\BotMan\BotMan::class => DI\factory(Factories\BotManFactory::class),
    Psr\Log\LoggerInterface::class => DI\factory(Factories\LoggerFactory::class),
];
