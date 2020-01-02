<?php

namespace App\Bootstrap;

use App\Commands;
use BotMan\BotMan\BotMan;
use PHLAK\Config\Config;
use Tightenco\Collect\Support\Collection;

class CommandsProvider extends Provider
{
    /** @var BotMan The BotMan component */
    protected $botman;

    /** @var Config The application config */
    protected $config;

    /**
     * Create a new CommandsProvider object.
     *
     * @param \BotMan\BotMan\BotMan $botman
     * @param \PHLAK\Config\Config  $config
     */
    public function __construct(BotMan $botman, Config $config)
    {
        $this->botman = $botman;
        $this->config = $config;
    }

    /**
     * Register chatbot commands.
     *
     * @return void
     */
    public function __invoke(): void
    {
        Collection::make(
            $this->config->get('botman.commands', [])
        )->each(function (string $command, string $pattern) {
            $this->botman->hears($pattern, $command);
        });

        $this->botman->fallback(Commands\Fallback::class);
    }
}
