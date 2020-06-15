<?php

namespace TheHostingTool\Bundle\CoreBundle\DependencyInjection\Parser;

use Tightenco\Collect\Support\Arr;
use Tightenco\Collect\Support\Collection;
use Webmozart\PathUtil\Path;

class GeneralParser extends BaseParser
{
    public function __construct(string $projectDir, string $initialFilename = 'config.yaml')
    {
        parent::__construct($projectDir, $initialFilename);
    }

    /**
     * Read and parse the config.yaml and config_local.yaml configuration files.
     */
    public function parse(): Collection
    {
        $defaultconfig = $this->getDefaultConfig();
        $tempconfig = $this->parseConfigYaml($this->getInitialFilename());
        $tempconfiglocal = $this->parseConfigYaml($this->getFilenameLocalOverrides(), true);


    }

    /**
     * Assume sensible defaults for a number of options.
     */
    protected function getDefaultConfig(): array
    {
        return [
            'database' => [
                'driver' => 'sqlite',
                'host' => 'localhost',
                'slaves' => [],
                'dbname' => 'tht',
                'prefix' => 'tht_',
                'charset' => 'utf8',
                'collate' => 'utf8_unicode_ci',
                'randomfunction' => '',
            ],
            'sitename' => 'TheHostingTool',
            'locale' => null,
            'theme' => '',
            'enforce_ssl' => false,
        ];
    }
}