<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Api;

use TheHostingTool\Http\RouteCollectionUrlGenerator;

class UrlGenerator extends RouteCollectionUrlGenerator
{
	/**
	 * {@inheritdoc}
	 */
	protected $path = 'api';
}