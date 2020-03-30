<?php

namespace App\Factories;

use DI\Container;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class LoggerFactory
{
    /** @var Container The applicaiton container */
    protected $container;

    /**
     * Create a new LoggingFactory object.
     *
     * @param \DI\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Register the application logging component.
     *
     * @return \Psr\Log\LoggerInterface
     */
    public function __invoke(): LoggerInterface
    {
        return (new Logger('app'))->pushHandler(new StreamHandler('php://stderr'));
    }
}
