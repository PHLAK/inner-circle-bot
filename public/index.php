<?php

use App\Bootstrap\AppManager;
use DI\ContainerBuilder;
use Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

// Initialize environment variable handler
Dotenv::createImmutable(dirname(__DIR__))->load();

// Initialize the container
$container = (new ContainerBuilder)->addDefinitions(
    dirname(__DIR__) . '/config/app.php'
);

if (getenv('APP_DEBUG') !== 'true') {
    $container->enableCompilation(dirname(__DIR__) . '/cache');
}

// Initialize the application
$app = $container->build()->call(AppManager::class);

// Enagage!
$app->run();
