<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Foundation\Twig;

use Illuminate\Contracts\Container\Container;
use TheHostingTool\Foundation\AbstractServiceProvider;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

class TwigServiceProvider extends AbstractServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->bind('twig.options', function () {
            return [
                'cache' => $this->app->cachePath(),
            ];
        });

        $this->app->bind(LoaderInterface::class, function () {
            // todo: load the name of the to use from the database
            return new FilesystemLoader($this->app->stylesPath().'default/');
        });

        $this->app->bind(Environment::class, function (Container $container) {
            $env = new Environment($container->make(LoaderInterface::class), $container->make('twig.options'));

            return $env;
        });
    }

    public function provides()
    {
        return [
            LoaderInterface::class
        ];
    }
}