<?php

namespace App\Commands;

use BotMan\BotMan\BotMan;
use Carbon\Carbon;
use Tightenco\Collect\Support\Collection;

class Dilbert
{
    /** @const The date of the earliest comic */
    protected const START_DATE = '1989-04-16';

    /**
     * Handle the incoming request.
     *
     * @param \BotMan\BotMan\BotMan $botman
     * @param string                $date
     *
     * @return void
     */
    public function __invoke(BotMan $botman, string $date = null)
    {
        if (Carbon::parse($date)->lt(Carbon::parse(self::START_DATE))) {
            $botman->reply('ERROR: Date out of range');

            return;
        }

        switch ($date) {
            case 'random':
                $date = Collection::make(
                    Carbon::parse(self::START_DATE)->daysUntil(Carbon::now())
                )->random();
                break;

            default:
                $date = Carbon::parse($date, 'America/Phoenix');
                break;
        }

        $botman->reply(sprintf('http://dilbert.com/strip/%s', $date->format('Y-m-d')));
    }
}
