<?php

namespace App\Commands;

use App\Http\Clients\SMBCClient;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use GuzzleHttp\Exception\ClientException;

class SMBC
{
    /**
     * Handle the incoming request.
     *
     * @param \BotMan\BotMan\BotMan        $botman
     * @param \App\Http\Clients\SMBCClient $smbc
     *
     * @return void
     */
    public function __invoke(BotMan $botman, ?SMBCClient $smbc = null)
    {
        try {
            $comic = ($smbc ?? new SMBCClient)->latest();
        } catch (ClientException $exception) {
            $botman->reply(
                sprintf('ERROR: Failed to fetch comic [%s]', $exception->getMessage())
            );

            return;
        }

        $botman->reply(OutgoingMessage::create(
                sprintf('<strong>%s</strong> • %s', $comic->title, $comic->altText)
        )->withAttachment(
            new Image($comic->imageUrl)
        ), ['parse_mode' => 'HTML']);
    }
}
