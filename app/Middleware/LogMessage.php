<?php

namespace App\Middleware;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Interfaces\Middleware\Received;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use Psr\Log\LoggerInterface;

class LogMessage implements Received
{
    protected LoggerInterface $log;

    /** Create a new MessageLogger object. */
    public function __construct(LoggerInterface $logger)
    {
        $this->log = $logger;
    }

    /**
     * Handle an incoming message.
     *
     * @param callable $next
     */
    public function received(IncomingMessage $message, $next, BotMan $bot)
    {
        $this->log->info('Incomming message', (array) $message->getPayload());

        return $next($message);
    }
}
