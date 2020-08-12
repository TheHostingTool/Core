<?php

namespace TheHostingTool\Bundle\SecurityBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SecurityExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach ($config['reset_password']['mail'] as $option => $value) {
            $container->setParameter('tht_security.reset_password.mail.'.$option, $value);
        }
    }

}