<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Database;

use TheHostingTool\Kernel\AbstractServiceProvider;
use TheHostingTool\Kernel\Application;
use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\Connectors\ConnectionFactory;
use PDO;

class DatabaseServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->app->singleton('tht.db', function () {
            $factory = new ConnectionFactory($this->app);

            $connection = $factory->make($this->app->config('database'));
            $connection->setEventDispatcher($this->app->make('Illuminate\Contracts\Events\Dispatcher'));
            $connection->setFetchMode(PDO::FETCH_CLASS);

            return $connection;
        });

        $this->app->alias('tht.db', 'Illuminate\Database\ConnectionInterface');

        $this->app->singleton('Illuminate\Database\ConnectionResolverInterface', function () {
            $resolver = new ConnectionResolver([
                'tht' => $this->app->make('tht.db'),
            ]);
            $resolver->setDefaultConnection('tht');

            return $resolver;
        });

        $this->app->alias('Illuminate\Database\ConnectionResolverInterface', 'db');

        $this->app->singleton('TheHostingTool\Database\MigrationRepositoryInterface', function ($app) {
            return new DatabaseMigrationRepository($app['db'], 'migrations');
        });

        $this->app->bind(MigrationCreator::class, function (Application $app) {
            return new MigrationCreator($app->make('Illuminate\Filesystem\Filesystem'), $app->basePath());
        });
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        if ($this->app->isInstalled()) {
            AbstractModel::setConnectionResolver($this->app->make('Illuminate\Database\ConnectionResolverInterface'));
            AbstractModel::setEventDispatcher($this->app->make('events'));
        }
    }
}
