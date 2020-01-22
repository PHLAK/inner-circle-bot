<?php

namespace App\Commands;

use App\Http\Clients\ExplosmClient;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use GuzzleHttp\Exception\ClientException;

class Explosm
{
    /**
     * Handle the incoming request.
     *
     * @param \BotMan\BotMan\BotMan                $botman
     * @param int|null                             $id
     * @param \App\Http\Clients\ExplosmClient|null $explosm
     *
     * @return void
     */
    public function __invoke(BotMan $botman, ?int $id = null, ?ExplosmClient $explosm = null)
    {
        $explosm = $explosm ?? new ExplosmClient();

        try {
            $comic = $id ? $explosm->byId($id) : $explosm->latest();
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
