<?php

namespace TheHostingTool\Bundle\CoreBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use TheHostingTool\Bundle\CoreBundle\Exception\ConfigurationException;
use Tightenco\Collect\Support\Collection;
use TheHostingTool\Bundle\CoreBundle\DependencyInjection\Parser\ThemeParser;

class CoreExtension extends Extension {
    
    public const EXTENSION_ALIAS = 'tht';

    /**
     * @var string
     */
    private $projectDir;

    /**
     * @var PathResolver
     */
    private $pathResolver;
    
    public function load(array $configs, ContainerBuilder $container): void
    {
        $this->projectDir = $container->getParameter('kernel.project_dir');

        $configuration = new Configuration(
            $this->projectDir,
            $container->getParameter('kernel.default_locale')
        );

        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        $loader->load('commands.yaml');

        $container->setParameter('tht.theme', $config['theme']);

        try {
            $this->pathResolver = new PathResolver($this->projectDir, $config['theme']);
            $theme = new ThemeParser($this->projectDir, $this->getPath('theme'));

        } catch (ConfigurationException $e) {
            // ignore
        }
    }
    
    public function getAlias(): string 
    {
        return self::EXTENSION_ALIAS;
    }

    public function getPath(string $path, bool $absolute = true, $additional = null): string
    {
        return $this->pathResolver->resolve($path, $absolute, $additional);
    }

    /**
     * @return Collection
     */
    public function getPaths(): Collection
    {
        return $this->pathResolver->resolveAll();
    }

}