<?php

namespace Tests\Commands;

use App\Commands\Btc;
use App\Http\Clients\CoinbaseClient;
use BotMan\BotMan\BotMan;
use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use Tests\TestCase;

class BtcTest extends TestCase
{
    public function test_it_can_get_the_current_price(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with(
            sprintf('<strong>Price on %s:</strong> $1,337.42', Carbon::now()->format('F jS, Y')),
            ['parse_mode' => 'HTML']
        );

        $coinbase = $this->createMock(CoinbaseClient::class);
        $coinbase->expects($this->once())->method('currentPrice')->willReturn(
            json_decode('{"data": {"base": "BTC", "currency": "USD", "amount": 1337.42}}')
        );

        (new Btc)($botman, null, $coinbase);
    }

    public function test_it_can_get_the_historical_price(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->with(
            '<strong>Price on May 20th, 1986:</strong> $1,337.42',
            ['parse_mode' => 'HTML']
        );

        $coinbase = $this->createMock(CoinbaseClient::class);
        $coinbase->expects($this->once())->method('priceOn')->willReturn(
            (object) ['data' => (object) [
                'base' => 'BTC',
                'currency' => 'USD',
                'amount' => 1337.42
            ]]
        );

        (new Btc)($botman, '1986-05-20', $coinbase);
    }

    public function test_it_returns_an_error_message_when_it_fails_to_fetch_the_price(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('reply')->willReturn(
            "ERROR: Failed to fetch price [418 I'm a teapot]"
        );

        $coinbase = $this->createMock(CoinbaseClient::class);
        $coinbase->expects($this->once())->method('currentPrice')->willThrowException(
            new ClientException("418 I'm a teapot", $this->createMock(Request::class))
        );

        (new Btc)($botman, null, $coinbase);
    }
}
