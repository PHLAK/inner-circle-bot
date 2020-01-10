<?php

namespace App\Commands;

use App\SMBCClient;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class SMBC
{
    /** @var SMBCClient The SMBC HTTP client */
    protected $smbc;

    public function __construct()
    {
        $this->smbc = new SMBCClient();
    }

    /**
     * Handle the incoming request.
     *
     * @param \BotMan\BotMan\BotMan $botman
     * @param \App\SMBCClient       $smbc
     *
     * @return void
     */
    public function __invoke(BotMan $botman, ?SMBCCLient $smbc = null)
    {
        $comic = ($smbc ?? new SMBCClient())->latest();

        $botman->reply(OutgoingMessage::create(
                sprintf('<strong>%s</strong> • %s', $comic->title, $comic->alt_text)
        )->withAttachment(
            new Image($comic->image)
        ), ['parse_mode' => 'HTML']);
    }
}
