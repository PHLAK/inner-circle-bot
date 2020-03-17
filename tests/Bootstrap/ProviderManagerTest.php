<?php

namespace Tests\Bootstrap;

use App\Bootstrap\ProviderManager;
use App\Providers;
use BotMan\BotMan\BotMan;
use DI\Container;
use Invoker\CallableResolver;
use PHLAK\Config\Interfaces\ConfigInterface;
use Psr\Log\LoggerInterface;
use Tests\TestCase;

class ProviderManagerTest extends TestCase
{
    /** @const Array of application providers */
    protected const PROVIDERS = [
        Providers\ConfigProvider::class,
        Providers\LoggingProvider::class,
        Providers\BotManProvider::class,
        Providers\CommandsProvider::class,
    ];

    public function test_it_registers_the_application_providers(): void
    {
        $container = new Container;
        $container->set('base_path', $this->path());

        (new ProviderManager($container, $container->get(CallableResolver::class)))();

        $this->assertTrue($container->has(ConfigInterface::class));
        $this->assertTrue($container->has(LoggerInterface::class));
        $this->assertTrue($container->has(BotMan::class));
    }
}
