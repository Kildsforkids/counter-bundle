<?php

namespace Kildsforkids\CounterBundle;

use Kildsforkids\CounterBundle\DependencyInjection\CounterExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CounterBundle extends Bundle
{
    public function getPath(): string
    {
        return dirname(__DIR__);
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CounterExtension();
    }
}