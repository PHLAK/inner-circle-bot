<?php

use App\Bootstrap\AppManager;
use DI\ContainerBuilder;
use Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

// Initialize environment variable handler
Dotenv::createUnsafeImmutable(dirname(__DIR__))->load();

// Initialize the container
$container = (new ContainerBuilder)->addDefinitions(
    dirname(__DIR__) . '/config/app.php'
);

// Compile the container
if (filter_var(getenv('APP_DEBUG'), FILTER_VALIDATE_BOOLEAN) !== true) {
    $container->enableCompilation(dirname(__DIR__) . '/cache');
}

// Initialize the application
$app = $container->build()->call(AppManager::class);

// Enagage!
$app->run();
