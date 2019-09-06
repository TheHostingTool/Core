<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Settings;

use TheHostingTool\Foundation\AbstractServiceProvider;
use Illuminate\Database\ConnectionInterface;

class SettingsServiceProvider extends AbstractServiceProvider
{

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->app->singleton(SettingsRepositoryInterface::class, function () {
            return new MemoryCacheSettingsRepository(
                new DatabaseSettingsRepository(
                    $this->app->make(ConnectionInterface::class)
                )
            );
        });

        $this->app->alias(SettingsRepositoryInterface::class, 'tht.settings');
    }

}