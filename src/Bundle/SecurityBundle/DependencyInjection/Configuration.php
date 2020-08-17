<?php

namespace TheHostingTool\Bundle\SecurityBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $builder = new TreeBuilder('tht_security');
        $rootNode = $builder->getRootNode();

        $this->addResetPasswordSection($rootNode);
        $this->addObjectsSection($rootNode);
        return $builder;
    }

    private function addObjectsSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('objects')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('user')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')
                                    ->defaultValue('TheHostingTool\Bundle\SecurityBundle\Entity\User')
                                ->end()
                                ->scalarNode('repository')
                                    ->defaultValue('TheHostingTool\Bundle\SecurityBundle\Repository\UserRepository')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    private function addResetPasswordSection(ArrayNodeDefinition  $node)
    {
        $node
            ->children()
                ->arrayNode('reset_password')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('mail')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->integerNode('token_sent_limit')
                                    ->min(1)
                                    ->defaultValue(3)
                                ->end()
                                ->scalarNode('sender')
                                    ->defaultValue('')
                                ->end()
                                ->scalarNode('subject')
                                    ->cannotBeEmpty()
                                    ->defaultValue('tht_security.reset_mail_subject')
                                ->end()
                                ->scalarNode('template')
                                    ->cannotBeEmpty()
                                    ->defaultValue('@ThtSecurity/mail_templates/reset_password.html.twig')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end();
    }

}