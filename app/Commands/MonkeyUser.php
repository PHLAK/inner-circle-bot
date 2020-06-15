<?php

namespace App\Commands;

use App\Http\Clients\MonkeyUserClient;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use GuzzleHttp\Exception\ClientException;

class MonkeyUser
{
    /** Handle the incoming request. */
    public function __invoke(BotMan $botman, ?MonkeyUserClient $monkeyuser = null): void
    {
        try {
            $comic = ($monkeyuser ?? new MonkeyUserClient)->latest();
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
