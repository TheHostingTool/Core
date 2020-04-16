<?php

namespace TheHostingTool\CoreBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class CoreExtension extends Extension {
    
    public const EXTENSION_ALIAS = 'tht';
    
    public function load(array $configs, ContainerBuilder $container): void
    {
    }
    
    public function getAlias(): string 
    {
        return self::EXTENSION_ALIAS;
    }

}