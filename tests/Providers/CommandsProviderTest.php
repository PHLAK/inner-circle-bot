<?php

namespace Tests\Providers;

use App\Commands;
use App\Providers\CommandsProvider;
use BotMan\BotMan\BotMan;
use Tests\TestCase;

class CommandsProviderTest extends TestCase
{
    public function test_it_registers_commands(): void
    {
        $botman = $this->createMock(BotMan::class);
        $botman->expects($this->once())->method('hears')->with(
            'ping', Commands\Ping::class
        );

        (new CommandsProvider($botman, $this->config))();
    }
}
