<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Http\Exceptions;

use Exception;

class RouteNotFoundException extends Exception
{
	public function __construct($message = null, $code = 404, Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}