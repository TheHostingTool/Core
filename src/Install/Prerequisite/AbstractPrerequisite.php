<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Install\Prerequisite;

abstract class AbstractPrerequisite implements PrerequisiteInterface
{

	protected $errors = [];

	abstract public function check();

	public function getErrors()
	{
		return $this->errors;
	}

}