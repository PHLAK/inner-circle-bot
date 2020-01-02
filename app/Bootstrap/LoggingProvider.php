<?php

namespace App\Bootstrap;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class LoggingProvider extends Provider
{
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
