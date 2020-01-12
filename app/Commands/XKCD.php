<?php

namespace App\Commands;

use App\Http\Clients\XKCDClient;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use GuzzleHttp\Exception\ClientException;

class XKCD
{
    /**
     * Handle the incoming request.
     *
     * @param \BotMan\BotMan\BotMan $botman
     * @param int|null              $id
     * @param \App\XKCDClient|null  $xkcd
     *
     * @return void
     */
    public function __invoke(BotMan $botman, ?int $id = null, ?XKCDClient $xkcd = null)
    {
        $xkcd = $xkcd ?? new XKCDClient();

        try {
            $comic = $id ? $xkcd->byId($id) : $xkcd->latest();
        } catch (ClientException $exception) {
            $botman->reply(
                sprintf('ERROR: Failed to fetch comic [%s]', $exception->getMessage())
            );

            return;
        }

        $botman->reply(OutgoingMessage::create(
            sprintf('<strong>%s</strong> • %s', $comic->safe_title, $comic->alt)
        )->withAttachment(
            new Image($comic->img)
        ), ['parse_mode' => 'HTML']);
    }
}
