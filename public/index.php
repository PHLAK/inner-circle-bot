<?php

use App\Bootstrap\AppManager;
use App\Controllers;
use App\Support\Helpers;
use DI\Container;
use Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

// Initialize environment variable handler
Dotenv::createImmutable(dirname(__DIR__))->load();

// Initialize the container
$container = new Container();
$container->set('base_path', dirname(__DIR__));

// Configure the application
$app = $container->call(AppManager::class);

// Register web routes
$app->post('/' . Helpers::env('TELEGRAM_TOKEN'), Controllers\Telegram::class);

// Enagage!
$app->run();
