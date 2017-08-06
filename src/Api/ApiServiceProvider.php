<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Api;

use TheHostingTool\Kernel\AbstractServiceProvider;
use TheHostingTool\Http\RouteCollection;

class ApiServiceProvider extends AbstractServiceProvider
{

	/**
	 * {@inheritdoc}
	 */
	public function register()
	{

		$this->app->singleton(UrlGenerator::class, function() {
			return new UrlGenerator($this->app, $this->app->make('tht.api.routes'));
		});

		$this->app->singleton('tht.api.routes', function() {
			return new RouteCollection();
		});

	}

	/**
	 * {@inheritdoc}
	 */
	public function boot()
	{
		$this->populateRoutes($this->app->make('tht.api.routes'));

	}


	/**
	 * Populate the API routes.
	 *
	 * @param RouteCollection $routes
	 */
	protected function populateRoutes(RouteCollection $routes)
	{

	}

}

