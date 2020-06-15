<?php

namespace Tests;

use App\Commands;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Drivers\Tests\ProxyDriver;
use DI\Container;
use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use RuntimeException;

class TestCase extends PHPUnitTestCase
{
    protected Container $container;
    protected BotMan $botman;

    /** This method is called before each test. */
    public function setUp(): void
    {
        $this->container = (new ContainerBuilder)->addDefinitions(
            dirname(__DIR__) . '/config/app.php'
        )->build();

        $this->container->set('base_path', $this->path());
        $this->container->set('commands', ['ping' => Commands\Ping::class]);

        DriverManager::loadDriver(ProxyDriver::class);
        $this->botman = BotManFactory::create(
            $this->container->get('botman_config')
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
