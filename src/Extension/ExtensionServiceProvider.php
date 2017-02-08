<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Extension;

use TheHostingTool\Kernel\AbstractServiceProvider;

class ExtensionServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->app->bind('tht.extensions', 'TheHostingTool\Extension\ExtensionManager');

        $bootstrappers = $this->app->make('tht.extensions')->getEnabledBootstrappers();

        foreach ($bootstrappers as $file) {
            $bootstrapper = require $file;

            $this->app->call($bootstrapper);
        }
    }
}
