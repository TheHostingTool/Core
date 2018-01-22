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

if (!function_exists('app_path')) {
	/**
	 * Get the path to the application folder.
	 *
	 * @param  string  $path
	 * @return string
	 */
	function app_path($path = '')
	{
		return app('path').($path ? DIRECTORY_SEPARATOR.$path : $path);
	}
}

if (!function_exists('base_path')) {
	/**
	 * Get the path to the base of the install.
	 *
	 * @param  string  $path
	 * @return string
	 */
	function base_path($path = '')
	{
		return app()->basePath().($path ? DIRECTORY_SEPARATOR.$path : $path);
	}
}

if (!function_exists('public_path')) {
	/**
	 * Get the path to the public folder.
	 *
	 * @param  string  $path
	 * @return string
	 */
	function public_path($path = '')
	{
		return app()->publicPath().($path ? DIRECTORY_SEPARATOR.$path : $path);
	}
}

if (!function_exists('storage_path')) {
	/**
	 * Get the path to the storage folder.
	 *
	 * @param  string  $path
	 * @return string
	 */
	function storage_path($path = '')
	{
		return app('path.storage').($path ? DIRECTORY_SEPARATOR.$path : $path);
	}
}

if (!function_exists('styles_path')) {
	/**
	 * Get the path to the styles folder
	 *
	 * @param string $path
	 * @return string
	 */
	function styles_path($path = '')
	{
		return app('path.styles').($path ? DIRECTORY_SEPARATOR.$path : $path);
	}
}

if (!function_exists('event')) {
	/**
	 * Fire an event and call the listeners.
	 *
	 * @param  string|object  $event
	 * @param  mixed  $payload
	 * @param  bool  $halt
	 * @return array|null
	 */
	function event($event, $payload = [], $halt = false)
	{
		return app('events')->fire($event, $payload, $halt);
	}
}