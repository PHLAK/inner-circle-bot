<?php

namespace App\Commands;

use App\Http\Clients\CoinbaseClient;
use BotMan\BotMan\BotMan;
use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use NumberFormatter;
use Tightenco\Collect\Support\Collection;

class Btc
{
    /** @const Array of sticker IDs */
    protected const STICKER_IDS = [
        'CAACAgIAAxkBAAIl5F5C_iECLpOpC7_O_FZai2Ki9_sEAAIrBgAClvoSBWfibcvyr59BGAQ',
        'CAACAgIAAxkBAAIl615C_tsPcny0eJxr9i7SG6o3BeDrAAIUBgAClvoSBRQaZ_yiYCJvGAQ',
        'CAACAgIAAxkBAAIl7V5C_uoYJ5l91n8WNMEBSFov46DKAAL8BQAClvoSBfP45oIb_tb9GAQ',
        'CAACAgIAAxkBAAIl715C_vjocN4BQu86UT1r49vxdnwzAAIIBgAClvoSBcJQcBHeJ36WGAQ',
        'CAACAgIAAxkBAAIl8V5C_wg_D42ZAULQB_IbM6CK_T8-AAIkBgAClvoSBdvpo6DwpLO-GAQ',
        'CAACAgIAAxkBAAIl815C_xTjj9LYupGrPsZNFZnPbiqAAAImBgAClvoSBT54uAwflqC1GAQ',
        'CAACAgIAAxkBAAIl9V5C_xs7xP3cHnmp3ImR1dklc9C_AAL5BQAClvoSBWGMTeRYo89hGAQ',
        'CAACAgIAAxkBAAIl915C_yZalVj1b7YNPteAaJxJMCMxAAIjBgAClvoSBRG5NgABoPOWfBgE',
        'CAACAgIAAxkBAAIl-V5C_zO1VBU1TT9asHdmORgL7FCNAAIhBgAClvoSBZR14Lgl_SMkGAQ',
        'CAACAgIAAxkBAAIl-15C_0Qz1iKGBKzAHv2hJClW7u7OAAMGAAKW-hIFYZOr_0h87woYBA',
    ];

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
        if (Carbon::parse($date)->isFuture()) {
            $botman->sendRequest('sendSticker', [
                'sticker' => Collection::make(self::STICKER_IDS)->random()
            ]);

            return;
        }

        $coinbase = $coinbase ?? new CoinbaseClient();

        try {
            $btc = $date ? $coinbase->priceOn(Carbon::parse($date)) : $coinbase->currentPrice();
        } catch (ClientException $exception) {
            $botman->reply(
                sprintf('ERROR: Failed to fetch price [%s]', $exception->getMessage())
            );

            return;
        }

        $botman->reply(sprintf(
            '<strong>Price on %s:</strong> %s',
            Carbon::parse($date)->format('F jS, Y'),
            $this->formatCurrency($btc->data->amount)
        ), ['parse_mode' => 'HTML']);
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
