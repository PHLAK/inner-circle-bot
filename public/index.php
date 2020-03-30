<?php

use App\Bootstrap\AppManager;
use DI\ContainerBuilder;
use Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

// Initialize environment variable handler
Dotenv::createImmutable(dirname(__DIR__))->load();

// Initialize the application
$app = (new ContainerBuilder)->addDefinitions(
    dirname(__DIR__) . '/config/app.php'
)->build()->call(AppManager::class);

// Enagage!
$app->run();
