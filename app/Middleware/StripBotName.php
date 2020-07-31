<?php

namespace App\Middleware;

use App\Config;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Interfaces\Middleware\Received;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;

class StripBotName implements Received
{
    protected Config $config;

    /** Create a new StripBotName object. */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Handle an incoming message.
     *
     * @param callable $next
     */
    public function received(IncomingMessage $message, $next, BotMan $bot)
    {
        $botName = (string) $this->config->get('bot_name');

        if (preg_match("/^[^@\s]+@{$botName}.*$/", $message->getText())) {
            $canonicalized = preg_replace("/@{$botName}/", '', $message->getText());
            $message->setText($canonicalized);
        }

        return $next($message);
    }
}
