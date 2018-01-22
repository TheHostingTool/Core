<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Install;

use TheHostingTool\Foundation\AbstractServiceProvider;
use TheHostingTool\Http\RouteCollection;
use TheHostingTool\Http\RouteHandlerFactory;
use TheHostingTool\Install\Prerequisite\PhpVersion;
use TheHostingTool\Install\Prerequisite\PrerequisiteInterface;
use TheHostingTool\Install\Prerequisite\Composite;

class InstallServiceProvider extends AbstractServiceProvider
{

	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
		$this->app->bind(
			PrerequisiteInterface::class,
			function() {
				return new Composite(
					new PhpVersion('7.0.0')
				);
			}
		);

		$this->app->singleton('tht.install.routes', function () {
			return new RouteCollection;
		});

		$this->loadViewsFrom(__DIR__.'/../../views/install', 'thr.install');

	}

	/**
	 * {@inheritdoc}
	 */
	public function boot()
	{
		$this->populateRoutes($this->app->make('flarum.install.routes'));
	}

	/**
	 * @param RouteCollection $routes
	 */
	protected function populateRoutes(RouteCollection $routes)
	{
		$route = $this->app->make(RouteHandlerFactory::class);

		$routes->get(
			'/',
			'index',
			$route->toController(Controller\IndexController::class)
		);

	}

}