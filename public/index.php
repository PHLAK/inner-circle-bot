<?php

use App\Bootstrap\AppManager;
use App\Controllers;
use App\Support\Helpers;
use DI\Container;
use Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

// Initialize environment variable handler
Dotenv::createImmutable(dirname(__DIR__))->load();

// Initialize the application
$app = (new Container)->call(AppManager::class, [dirname(__DIR__)]);

// Register web routes
$app->post('/' . Helpers::env('TELEGRAM_TOKEN'), Controllers\Telegram::class);

// Enagage!
$app->run();
