<?php

namespace App\Middleware;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Interfaces\Middleware\Received;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;

class StripLeadingSlash implements Received
{
    /**
     * Handle an incoming message.
     *
     * @param callable $next
     */
    public function received(IncomingMessage $message, $next, BotMan $bot)
    {
        preg_match('/\/?(.+)/', $message->getText(), $matches);
        $message->setText($matches[1]);

        return $next($message);
    }
}
