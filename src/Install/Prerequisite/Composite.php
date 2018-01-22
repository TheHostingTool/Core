<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Install\Prerequisite;

class Composite implements PrerequisiteInterface
{
	/**
	 * @var PrerequisiteInterface[]
	 */
	protected $prerequisites = [];

	public function __construct(PrerequisiteInterface $first)
	{
		foreach (func_get_args() as $prerequisite) {
			$this->prerequisites[] = $prerequisite;
		}
	}

	public function check()
	{
		return array_reduce(
			$this->prerequisites,
			function ($previous, PrerequisiteInterface $prerequisite) {
				return $prerequisite->check() && $previous;
			},
			true
		);
	}

	public function getErrors()
	{
		return collect($this->prerequisites)->map(function (PrerequisiteInterface $prerequisite) {
			return $prerequisite->getErrors();
		})->reduce('array_merge', []);
	}
}