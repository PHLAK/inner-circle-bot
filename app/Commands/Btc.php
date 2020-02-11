<?php

namespace App\Commands;

use App\Http\Clients\CoinbaseClient;
use BotMan\BotMan\BotMan;
use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use NumberFormatter;

class Btc
{
    /**
     * Handle the incoming request.
     *
     * @param \BotMan\BotMan\BotMan            $botman
     * @param string                           $date
     * @param \App\Http\Clients\CoinbaseClient $coinbase
     *
     * @return void
     */
    public function __invoke(BotMan $botman, string $date = null, ?CoinbaseClient $coinbase = null)
    {
        $coinbase = $coinbase ?? new CoinbaseClient();

        try {
            $btc = $date ? $coinbase->priceOn(Carbon::parse($date)) : $coinbase->currentPrice();
        } catch (ClientException $exception) {
            $botman->reply(
                sprintf('ERROR: Failed to fetch price [%s]', $exception->getMessage())
            );

            return;
        }

        $botman->reply(
            sprintf(
                '<strong>Price on %s:</strong> %s',
                Carbon::parse($date)->format('F jS, Y'),
                $this->formatCurrency($btc->data->amount)
            ),
            ['parse_mode' => 'HTML']
        );
    }

    /**
     * Format a numeric value as currency.
     *
     * @param float $amount
     *
     * @return string
     */
    protected function formatCurrency(float $amount): string
    {
        $formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);

        return $formatter->formatCurrency($amount, 'USD');
    }
}
