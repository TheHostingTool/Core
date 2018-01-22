<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Http\Controller;

use Illuminate\Contracts\Support\Renderable;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;

abstract class AbstractHtmlController implements ControllerInterface
{
	/**
	 * @param Request $request
	 * @return HtmlResponse
	 */
	public function handle(Request $request)
	{
		$view = $this->render($request);

		if ($view instanceof Renderable) {
			$view = $view->render();
		}

		return new HtmlResponse($view);
	}

	/**
	 * @param Request $request
	 * @return string|Renderable
	 */
	abstract protected function render(Request $request);
}