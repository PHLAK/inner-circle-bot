<?php

namespace App\Middleware;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Interfaces\Middleware\Received;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use Psr\Log\LoggerInterface;

class LogMessage implements Received
{
    /** @var LoggerInterface */
    protected $log;

    /**
     * Create a new MessageLogger object.
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->log = $logger;
    }

    /**
     * Handle an incoming message.
     *
     * @param IncomingMessage $message
     * @param callable        $next
     * @param BotMan          $bot
     *
     * @return mixed
     */
    public function received(IncomingMessage $message, $next, BotMan $bot)
    {
        $this->log->info('Incomming message', (array) $message->getPayload());

        return $next($message);
    }
}
