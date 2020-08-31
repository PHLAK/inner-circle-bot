<?php

namespace App\Commands;

use App\Http\Clients\FoxTrotClient;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use GuzzleHttp\Exception\ClientException;

class FoxTrot
{
    /** Handle the incoming request. */
    public function __invoke(BotMan $botman, ?FoxTrotClient $foxtrot = null): void
    {
        try {
            $comic = ($foxtrot ?? new FoxTrotClient)->latest();
        } catch (ClientException $exception) {
            $botman->reply(
                sprintf('ERROR: Failed to fetch comic [%s]', $exception->getMessage())
            );

            return;
        }

        $botman->reply(OutgoingMessage::create(
            sprintf('<strong>%s</strong>', $comic->title)
        )->withAttachment(
            new Image($comic->imageUrl)
        ), ['parse_mode' => 'HTML']);
    }
}
