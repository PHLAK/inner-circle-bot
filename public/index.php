<?php

use App\Bootstrap;
use App\Controllers;
use App\Support\Helpers;
use DI\Bridge\Slim\Bridge;
use DI\Container;
use Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

// Initialize environment variable handler
Dotenv::createImmutable(dirname(__DIR__))->load();

// Initialize the container
$container = new Container();
$container->set('base_path', dirname(__DIR__));

// Configure the application components
$container->call(Bootstrap\ConfigProvider::class);
$container->call(Bootstrap\LoggingProvider::class);
$container->call(Bootstrap\BotManProvider::class);
$container->call(Bootstrap\CommandsProvider::class);

// Create the application
$app = Bridge::create($container);

// Register web routes
$app->post('/' . Helpers::env('TELEGRAM_TOKEN'), Controllers\Telegram::class);

// Enagage!
$app->run();
