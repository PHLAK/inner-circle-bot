<?php

namespace App\Factories;

use DI\Container;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class LoggerFactory
{
    protected Container $container;

    /** Create a new LoggingFactory object. */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /** Register the application logging component. */
    public function __invoke(): LoggerInterface
    {
        return (new Logger('app'))->pushHandler(new StreamHandler('php://stderr'));
    }
}
