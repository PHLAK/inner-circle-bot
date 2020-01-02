<?php

namespace App\Bootstrap;

use DI\Container;

abstract class Provider
{
    /** @var Container The applicaiton container */
    protected $container;

    /**
     * Create a new Provider object.
     *
     * @param \DI\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Register the application component.
     *
     * @return void
     */
    abstract public function __invoke(): void;
}
