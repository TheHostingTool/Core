<?php

namespace TheHostingTool\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use TheHostingTool\CoreBundle\DependencyInjection\CoreExtension;

class CoreBundle extends Bundle
{
    /**
     * TheHostingTool Core Version
     */
    public const VERSION = "1.0.0";

    public function getContainerExtension(): ExtensionInterface
    {
        return new CoreExtension();
    }
}