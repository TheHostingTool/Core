<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

use Illuminate\Container\Container;

if (!function_exists('app')) {
	/**
	 * Get the available container instance.
	 *
	 * @param  string  $make
	 * @param  array   $parameters
	 * @return mixed|\TheHostingTool\Foundation\Application
	 */
	function app($make = null, $parameters = [])
	{
		if (is_null($make)) {
			return Container::getInstance();
		}

		return Container::getInstance()->make($make, $parameters);
	}
}