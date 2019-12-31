<?php

namespace App\Commands;

use App\XKCDClient;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use GuzzleHttp\Exception\ClientException;

class XKCD
{
    /** @var XKCDClient The XKCD HTTP client */
    protected $xkcd;

    public function __construct()
    {
        $this->xkcd = new XKCDClient();
    }

    /**
     * Handle the incoming request.
     *
     * @param \BotMan\BotMan\BotMan $botman
     * @param int|null              $id
     *
     * @return void
     */
    public function __invoke(BotMan $botman, ?int $id = null)
    {
        try {
            $comic = $id ? $this->xkcd->byId($id) : $this->xkcd->latest();
        } catch (ClientException $exception) {
            $botman->reply(
                sprintf('ERROR: Failed to fetch comic [%s]', $exception->getMessage())
            );

            return;
        }

        $botman->reply(OutgoingMessage::create(
            sprintf('%s - %s', $comic->safe_title, $comic->alt)
        )->withAttachment(
            new Image($comic->img)
        ));
    }
}
