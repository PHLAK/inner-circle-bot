<?php

namespace Tests;

use App\Commands;
use App\Config;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Drivers\Tests\ProxyDriver;
use DI\Container;
use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use RuntimeException;

/** @coversNothing */
class TestCase extends PHPUnitTestCase
{
    protected Container $container;
    protected BotMan $botman;

    /** This method is called before each test. */
    protected function setUp(): void
    {
        $this->container = (new ContainerBuilder)->addDefinitions(
            ...glob(dirname(__DIR__) . '/config/*.php')
        )->build();

        $this->config = new Config($this->container);
        $this->container->set('base_path', $this->path());
        $this->container->set('commands', ['ping' => Commands\Ping::class]);

        DriverManager::loadDriver(ProxyDriver::class);
        $this->botman = BotManFactory::create(
            $this->config->get('botman_config')
        );

        $this->container->set(BotMan::class, $this->botman);
    }

    /**
     * Get the path to a test file.
     *
     * @throws RuntimeException
     */
    protected function path(string $file = '.'): string
    {
        $path = realpath(
            __DIR__ . DIRECTORY_SEPARATOR . '_data' . DIRECTORY_SEPARATOR . $file
        );

        if ($path === false) {
            throw new RuntimeException(sprintf('The file "%s" does not exist', $file));
        }

        return $path;
    }
}
