<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Theme;

use TheHostingTool\Database\Migrator;
use TheHostingTool\Events\Theme\ThemeWasDisabled;
use TheHostingTool\Events\Theme\ThemeWasEnabled;
use TheHostingTool\Events\Theme\ThemeWasUninstalled;
use TheHostingTool\Events\Theme\ThemeWillBeDisabled;
use TheHostingTool\Events\Theme\ThemeWillBeEnabled;
use TheHostingTool\Kernel\Application;
use TheHostingTool\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ThemeManager
{
    protected $config;

    protected $app;

    protected $migrator;

    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var Collection|null
     */
    protected $themes;

    public function __construct(
        SettingsRepositoryInterface $config,
        Application $app,
        Dispatcher $dispatcher,
        Filesystem $filesystem
    ) {
        $this->config = $config;
        $this->app = $app;
        $this->dispatcher = $dispatcher;
        $this->filesystem = $filesystem;
    }

    /**
     * @return Collection
     */
    public function getThemes()
    {
        if (is_null($this->themes) && $this->filesystem->exists($this->app->basePath().'/vendor/composer/installed.json')) {
            $themes = new Collection();

            // Load all packages installed by composer.
            $installed = json_decode($this->filesystem->get($this->app->basePath().'/vendor/composer/installed.json'), true);

            foreach ($installed as $package) {
                if (Arr::get($package, 'type') != 'tht-theme' || empty(Arr::get($package, 'name'))) {
                    continue;
                }
                // Instantiates an Extension object using the package path and composer.json file.
                $theme = new Theme($this->getThemesDir().'/'.Arr::get($package, 'name'), $package);

                // Per default all extensions are installed if they are registered in composer.
                $theme->setInstalled(true);
                $theme->setVersion(Arr::get($package, 'version'));
                $theme->setEnabled($this->isEnabled($theme->getId()));

                $themes->put($theme->getId(), $theme);
            }
            $this->themes = $themes->sortBy(function ($theme, $name) {
                return $theme->composerJsonAttribute('extra.tht-theme.title');
            });
        }

        return $this->themes;
    }

    /**
     * Loads an Theme with all information.
     *
     * @param string $name
     * @return Theme|null
     */
    public function getTheme($name)
    {
        return $this->getThemes()->get($name);
    }

    /**
     * Enables the theme.
     *
     * @param string $name
     */
    public function enable($name)
    {
        if (! $this->isEnabled($name)) {
            $theme = $this->getTheme($name);

            $this->dispatcher->fire(new ThemeWillBeEnabled($theme));

            $enabled = $this->getEnabled();

            $enabled[] = $name;

            $this->publishAssets($theme);

            $this->setEnabled($enabled);

            $theme->setEnabled(true);

            $this->dispatcher->fire(new ThemeWasEnabled($theme));
        }
    }

    /**
     * Disables an theme.
     *
     * @param string $name
     */
    public function disable($name)
    {
        $enabled = $this->getEnabled();

        if (($k = array_search($name, $enabled)) !== false) {
            $extension = $this->getTheme($name);

            $this->dispatcher->fire(new ThemeWillBeDisabled($extension));

            unset($enabled[$k]);

            $this->setEnabled($enabled);

            $extension->setEnabled(false);

            $this->dispatcher->fire(new ThemeWasDisabled($extension));
        }
    }

    /**
     * Uninstalls an theme.
     *
     * @param string $name
     */
    public function uninstall($name)
    {
        $theme = $this->getTheme($name);

        $this->disable($name);

        $this->unpublishAssets($theme);

        $theme->setInstalled(false);

        $this->dispatcher->fire(new ThemeWasUninstalled($theme));
    }

    /**
     * Copy the assets from an themes's assets directory into public view.
     *
     * @param Theme $theme
     */
    protected function publishAssets(Theme $theme)
    {
        if ($theme->hasAssets()) {
            $this->filesystem->copyDirectory(
                $theme->getPath().'/assets',
                $this->app->publicPath().'/assets/themes/'.$theme->getId()
            );
        }
    }

    /**
     * Delete a themes's assets from public view.
     *
     * @param Theme $theme
     */
    protected function unpublishAssets(Theme $theme)
    {
        $this->filesystem->deleteDirectory($this->app->publicPath().'/assets/themes/'.$theme->getId());
    }

    /**
     * Get the path to an thems's published asset.
     *
     * @param Theme $theme
     * @param string    $path
     * @return string
     */
    public function getAsset(Theme $theme, $path)
    {
        return $this->app->publicPath().'/assets/themes/'.$theme->getId().$path;
    }

    /**
     * Get only enabled theme.
     *
     * @return Collection
     */
    public function getEnabledExtensions()
    {
        return $this->getThemes()->only($this->getEnabled());
    }

    /**
     * Loads all bootstrap.php files of the enabled extensions.
     *
     * @return Collection
     */
    public function getEnabledBootstrappers()
    {
        $bootstrappers = new Collection;

        foreach ($this->getEnabledTheme() as $extension) {
            if ($this->filesystem->exists($file = $extension->getPath().'/bootstrap.php')) {
                $bootstrappers->push($file);
            }
        }

        return $bootstrappers;
    }

    /**
     * The id's of the enabled theme.
     *
     * @return array
     */
    public function getEnabled()
    {
        return json_decode($this->config->get('theme_enabled'), true);
    }

    /**
     * Persist the currently enabled theme.
     *
     * @param array $enabled
     */
    protected function setEnabled(array $enabled)
    {
        $enabled = array_values(array_unique($enabled));

        $this->config->set('theme_enabled', json_encode($enabled));
    }

    /**
     * Whether the theme is enabled.
     *
     * @param $extension
     * @return bool
     */
    public function isEnabled($extension)
    {
        return in_array($extension, $this->getEnabled());
    }

    /**
     * The extensions path.
     *
     * @return string
     */
    protected function getThemesDir()
    {
        return $this->app->basePath().'/themes';
    }
}
