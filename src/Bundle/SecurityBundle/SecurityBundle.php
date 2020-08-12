<?php

namespace TheHostingTool\Bundle\SecurityBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use TheHostingTool\Bundle\SecurityBundle\DependencyInjection\SecurityExtension;

class SecurityBundle extends Bundle
{
    /**
     * TheHostingTool SecurityBundle Version
     */
    public const VERSION = "1.0.0";

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }

    public function getContainerExtension(): ExtensionInterface
    {
        if (!isset($this->extension)) {
            $this->extension = new SecurityExtension();
        }

        return $this->extension;
    }
}