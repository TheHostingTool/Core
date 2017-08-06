<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Http\Handler;

use Illuminate\Contracts\Container\Container;

class RouteHandlerFactory
{
	/**
	 * @var Container
	 */
	protected $container;

	/**
	 * @param Container $container
	 */
	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	/**
	 * @param string $controller
	 * @return ControllerRouteHandler
	 */
	public function toController($controller)
	{
		return new ControllerRouteHandler($this->container, $controller);
	}
}