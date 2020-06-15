<?php

namespace TheHostingTool\Bundle\CoreBundle\DependencyInjection;

use TheHostingTool\Bundle\CoreBundle\Exception\ConfigurationException;
use Tightenco\Collect\Support\Collection;
use Webmozart\PathUtil\Path;

class PathResolver
{
    /** @var array */
    protected $paths = [];

    /** @var array */
    private $resolving = [];

    /**
     * Default paths for TheHostingTool installation.
     */
    public static function defaultPaths(string $public): array
    {
        return [
            'site' => '.',
            'var' => '%site%/var',
            'cache' => '%var%/cache',
            'config' => '%site%/config',
            'database' => '%var%/database',
            'extensions' => '%site%/extensions',
            'extensions_config' => '%config%/extensions',
            'web' => '%site%/' . $public,
            'uploads' => '%web%/uploads',
            'themes' => '%web%/themes',
            'plugins' => '%web%/plugins'
        ];
    }

    /**
     * @param string $root the root path which must be absolute
     *
     * @param string $themeName
     * @param string $public
     * @throws ConfigurationException
     */
    public function __construct(string $root, string $themeName = '', string $public = 'public')
    {
        $paths = $this->defaultPaths($public);

        foreach ($paths as $name => $path) {
            $this->define($name, $path);
        }

        $root = Path::canonicalize($root);

        if (Path::isRelative($root)) {
            throw new ConfigurationException('Root path must be absolute.');
        }

        $this->paths['root'] = $root;
        $this->paths['theme'] = '%themes%/' . $themeName;
    }

    /**
     * Define a path, or really an alias/variable.
     *
     * @param string $name
     * @param string $path
     * @throws ConfigurationException
     */
    public function define(string $name, string $path): void
    {
        if (mb_strpos($path, "%${name}%") !== false) {
            throw new ConfigurationException('Paths cannot reference themselves.');
        }

        $this->paths[$name] = $path;
    }

    /**
     * Resolve a path.
     *
     * Examples:
     *  - `%web%/files` - A path with variables.
     *  - `files` - A previously defined variable.
     *  - `foo/bar` - A relative path that will be resolved against the root path.
     *  - `/tmp` - An absolute path will be returned as is.
     *
     * @param bool $absolute if the path is relative, resolve it against the root path
     *
     */
    public function resolve(string $path, bool $absolute = true, $additional = null): string
    {
        if (isset($this->paths[$path])) {
            $path = $this->paths[$path];
        }

        $path = preg_replace_callback('#%(.+)%#', function ($match) use ($path) {
            $alias = $match[1];

            if (! isset($this->paths[$alias])) {
                throw new ConfigurationException("Failed to resolve path. Alias %${alias}% is not defined.");
            }

            // absolute if alias is at start of path
            $absolute = mb_strpos($path, "%${alias}%") === 0;

            if (isset($this->resolving[$alias])) {
                throw new ConfigurationException('Failed to resolve path. Infinite recursion detected.');
            }

            $this->resolving[$alias] = true;
            try {
                return $this->resolve($alias, $absolute);
            } finally {
                unset($this->resolving[$alias]);
            }
        }, $path);

        if ($absolute && Path::isRelative($path)) {
            $path = Path::makeAbsolute($path, $this->paths['root']);
        }

        if (! empty($additional)) {
            $path .= \DIRECTORY_SEPARATOR . implode(\DIRECTORY_SEPARATOR, (array) $additional);
        }

        // Make sure we don't have lingering unneeded dir-seperators
        return Path::canonicalize($path);
    }

    public function resolveAll(): Collection
    {
        $paths = [];
        foreach ($this->paths as $name => $path) {
            $paths[$name] = $this->resolve($path);
        }

        return new Collection($paths);
    }

    /**
     * Returns the raw path definition for the name given.
     * @param string $name
     * @return string|null
     */
    public function raw(string $name): ?string
    {
        return isset($this->paths[$name]) ? $this->paths[$name] : null;
    }

    /**
     * Returns all path names and their raw definitions.
     */
    public function rawAll(): array
    {
        $paths = $this->paths;
        unset($paths['root']);

        return $paths;
    }

    /**
     * Returns the names of all paths.
     */
    public function names(): array
    {
        return array_keys($this->rawAll());
    }
}