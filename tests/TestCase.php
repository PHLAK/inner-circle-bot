<?php

namespace Tests;

use App\Commands;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Drivers\Tests\ProxyDriver;
use DI\Container;
use PHLAK\Config\Config;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    /** @var Container The test container */
    protected $container;

    /** @var Config The test config */
    protected $config;

    /** @var \BotMan\BotMan\BotMan Test BotMan component */
    protected $botman;

    /**
     * This method is called before each test.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->container = new Container();
        $this->container->set('base_path', __DIR__ . '/data');

        $this->config = new Config([
            'app' => [
                'bot_name' => 'TestBot'
            ],
            'botman' => [
                'telegram' => [
                    'token' => 'TEST_TELEGRAM_TOKEN',
                ],

                'commands' => [
                    'ping' => Commands\Ping::class,
                ],
            ]
        ]);

        DriverManager::loadDriver(ProxyDriver::class);
        $this->botman = BotManFactory::create(
            $this->config->split('botman')->toArray()
        );
    }
}
