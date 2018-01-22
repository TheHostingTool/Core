<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Install\Prerequisite;

class PhpVersion extends AbstractPrerequisite
{
	protected $minVersion;

	public function __construct($minVersion)
	{
		$this->minVersion = $minVersion;
	}

	public function check()
	{
		if (version_compare(PHP_VERSION, '7.0.0', '<')) {
			$this->errors[] = [
				'message' => "PHP $this->minVersion is required.",
				'detail' => 'You are running version '.PHP_VERSION.'. Talk to your hosting provider about upgrading to the latest PHP version.',
			];
		}
	}
}