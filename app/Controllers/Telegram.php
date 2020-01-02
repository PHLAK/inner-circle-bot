<?php

namespace App\Controllers;

use BotMan\BotMan\BotMan;
use Slim\Psr7\Response;

class Telegram
{
    /**
     * Handle the incoming request.
     *
     * @param \BotMan\BotMan\BotMan $botman
     * @param \Slim\Psr7\Response   $response
     *
     * @return \Slim\Psr7\Response
     */
    public function __invoke(BotMan $botman, Response $response): Response
    {
        $botman->listen();

        return $response;
    }
}
