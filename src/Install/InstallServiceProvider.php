<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Install;

use TheHostingTool\Foundation\AbstractServiceProvider;

class InstallServiceProvider extends AbstractServiceProvider
{
    public function boot()
    {
        /**
         * @var \Illuminate\Routing\Router $router
         */
        $router = $this->app->make('router');

        $router->group(['namespace' => '\\TheHostingTool\\Install\\Controllers'], function(\Illuminate\Routing\Router $router) {
            
        });
    }

}
