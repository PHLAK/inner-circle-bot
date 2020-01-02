<?php

namespace App\Middleware;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Interfaces\Middleware\Sending;
use Psr\Log\LoggerInterface;

class LogResponse implements Sending
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
     * Handle an outgoing message payload before/after it
     * hits the message service.
     *
     * @param mixed    $payload
     * @param callable $next
     * @param BotMan   $bot
     *
     * @return mixed
     */
    public function sending($payload, $next, BotMan $bot)
    {
        $this->log->info('Outgoing response', (array) $payload);

        return $next($payload);
    }
}
