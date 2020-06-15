<?php

namespace App\Controllers;

use BotMan\BotMan\BotMan;
use Slim\Psr7\Response;

class Telegram
{
    /** Handle the incoming request. */
    public function __invoke(BotMan $botman, Response $response): Response
    {
        $botman->listen();

        return $response;
    }
}
