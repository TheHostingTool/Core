<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Settings;

use TheHostingTool\Kernel\AbstractServiceProvider;

class SettingsServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->app->singleton('TheHostingTool\Settings\SettingsRepositoryInterface', function () {
            return new MemoryCacheSettingsRepository(
                new DatabaseSettingsRepository(
                    $this->app->make('Illuminate\Database\ConnectionInterface')
                )
            );
        });

        $this->app->alias('TheHostingTool\Settings\SettingsRepositoryInterface', 'tht.settings');
    }
}