<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Install\Prerequisite;

interface PrerequisiteInterface
{
	public function check();

	public function getErrors();
}