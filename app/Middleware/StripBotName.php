<?php

namespace App\Middleware;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Interfaces\Middleware\Received;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use PHLAK\Config\Config;
use PHLAK\Config\Interfaces\ConfigInterface;

class StripBotName implements Received
{
    /** @var ConfigInterface Application config */
    protected $config;

    /**
     * Create a new StripBotName object.
     *
     * @param \PHLAK\Config\Interfaces\ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
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

        if (preg_match("/^[^@\s]+@{$botName}.*$/", $message->getText())) {
            $canonicalized = preg_replace("/@{$botName}/", '', $message->getText());
            $message->setText($canonicalized);
        }

        return $next($message);
    }
}
