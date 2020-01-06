<?php

namespace App\Providers;

use DI\Container;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class LoggingProvider
{
    /** @var Container The applicaiton container */
    protected $container;

    /**
     * Create a new LoggingProvider object.
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
     * @return void
     */
    public function __invoke(): void
    {
        $this->container->set(LoggerInterface::class, function () {
            $logger = new Logger('app');
            $logger->pushHandler(new StreamHandler('php://stderr'));

            return $logger;
        });
    }
}
