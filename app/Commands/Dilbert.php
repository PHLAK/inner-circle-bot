<?php

namespace App\Commands;

use App\Http\Clients\DilbertClient;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;

class Dilbert
{
    /** Handle the incoming request. */
    public function __invoke(BotMan $botman, ?string $date = null, ?DilbertClient $dilbert = null): void
    {
        $dilbert = $dilbert ?? new DilbertClient();

        try {
            switch ($date) {
                case null:
                    $comic = $dilbert->latest();

                    break;

                case 'random':
                    $comic = $dilbert->random();

                    break;

                default:
                    $comic = $dilbert->byDate(Carbon::parse($date, 'America/Phoenix'));

                    break;
            }
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
