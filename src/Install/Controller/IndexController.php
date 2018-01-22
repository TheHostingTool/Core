<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Install\Controller;

use TheHostingTool\Http\Controller\AbstractHtmlController;
use TheHostingTool\Install\Prerequisite\PrerequisiteInterface;
use Illuminate\Contracts\View\Factory;
use Psr\Http\Message\ServerRequestInterface as Request;

class IndexController extends AbstractHtmlController
{

	/**
	 * @var Factory
	 */
	protected $view;

	/**
	 * @var \TheHostingTool\Install\Prerequisite\PrerequisiteInterface
	 */
	protected $prerequisite;

	/**
	 * @param Factory $view
	 * @param PrerequisiteInterface $prerequisite
	 */
	public function __construct(Factory $view, PrerequisiteInterface $prerequisite)
	{
		$this->view = $view;
		$this->prerequisite = $prerequisite;
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function render(Request $request)
	{
		$view = $this->view->make('tht.install::app')->with('title', 'Install TheHostingTool');
		$this->prerequisite->check();
		$errors = $this->prerequisite->getErrors();

		if (count($errors)) {
			$view->with('content', $this->view->make('tht.install::errors')->with('errors', $errors));
		} else {
			$view->with('content', $this->view->make('tht.install::install'));
		}

		return $view;
	}

}