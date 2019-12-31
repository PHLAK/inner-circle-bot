<?php

namespace App\Middleware;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Interfaces\Middleware\Received;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use PHLAK\Config\Config;

class StripBotName implements Received
{
    /** @var Config Application config */
    protected $config;

    /**
     * Create a new StripBotName object.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
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
        $botName = (string) $this->config->get('app.bot_name');
        $canonicalized = preg_replace("/@{$botName}/", '', $message->getText());
        $message->setText($canonicalized);

        return $next($message);
    }
}
