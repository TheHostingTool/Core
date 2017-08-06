<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Http;

use TheHostingTool\Core\AuthToken;
use TheHostingTool\Core\EmailToken;
use TheHostingTool\Core\PasswordToken;
use TheHostingTool\Kernel\AbstractServer as BaseAbstractServer;
use TheHostingTool\Kernel\Application;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Server;
use Zend\Stratigility\MiddlewareInterface;
use Zend\Stratigility\NoopFinalHandler;

abstract class AbstractServer extends BaseAbstractServer
{
	public function listen()
	{
		Server::createServer(
			$this,
			$_SERVER,
			$_GET,
			$_POST,
			$_COOKIE,
			$_FILES
		)->listen(new NoopFinalHandler());
	}

	/**
	 * Use as PSR-7 middleware.
	 *
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param callable $out
	 * @return ResponseInterface
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $out)
	{
		$app = $this->getApp();
		$this->collectGarbage($app);
		$middleware = $this->getMiddleware($app);
		return $middleware($request, $response, $out);
	}

	/**
	 * @param Application $app
	 * @return MiddlewareInterface
	 */
	abstract protected function getMiddleware(Application $app);

	private function collectGarbage()
	{
		if ($this->hitsLottery()) {
			AccessToken::whereRaw('last_activity <= ? - lifetime', [time()])->delete();
			$earliestToKeep = date('Y-m-d H:i:s', time() - 24 * 60 * 60);
			EmailToken::where('created_at', '<=', $earliestToKeep)->delete();
			PasswordToken::where('created_at', '<=', $earliestToKeep)->delete();
			AuthToken::where('created_at', '<=', $earliestToKeep)->delete();
		}
	}

	private function hitsLottery()
	{
		return mt_rand(1, 100) <= 2;
	}

}