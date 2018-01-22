<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Http;

use TheHostingTool\Http\Middleware\DispatchRoute;
use TheHostingTool\Foundation\Kernel;
use TheHostingTool\Foundation\Application;
use TheHostingTool\Http\Middleware\StartSession;
use TheHostingTool\Install\InstallServiceProvider;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Server as DiactorosServer;
use Zend\Stratigility\MiddlewareInterface;
use Zend\Stratigility\MiddlewarePipe;
use Zend\Stratigility\NoopFinalHandler;

class Server
{
	/**
	 * @param Kernel $kernel
	 * @return Server
	 */
	public static function fromKernel(Kernel $kernel)
	{
		return new static($kernel->boot());
	}

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	public function listen()
	{
		DiactorosServer::createServer(
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
		$middleware = $this->getMiddleware($request->getUri()->getPath());
		return $middleware($request, $response, $out);
	}

	/**
	 * @param string $requestPath
	 * @return MiddlewarePipe
	 */
	protected function getMiddleware($requestPath)
	{
		$pipe = new MiddlewarePipe;
		//$pipe->raiseThrowables();

		if (!$this->app->isInstalled()) {
			return $this->getInstallerMiddleware($pipe);
		}

		if ($this->app->isDownForMaintenance()) {
			return $this->getMaintenanceMiddleware($pipe);
		}

		if (!$this->app->isUpToDate()) {
			return $this->getUpdaterMiddleware($pipe);
		}

		$api = parse_url($this->app->url('api'), PHP_URL_PATH);
		$admin = parse_url($this->app->url('admin'), PHP_URL_PATH);
		$frontend = parse_url($this->app->url(''), PHP_URL_PATH) ?: '/';
		$clientarea = parse_url($this->app->url('clients'), PHP_URL_PATH );

		if ($this->pathStartsWith($requestPath, $api)) {
			$pipe->pipe($api, $this->app->make('tht.api.middleware'));
		} elseif ($this->pathStartsWith($requestPath, $admin)) {
			$pipe->pipe($admin, $this->app->make('tht.admin.middleware'));
		} elseif($this->pathStartsWith($requestPath, $clientarea)) {
			$pipe->pipe($clientarea, $this->app->make('tht.clients.middleware'));
		} else {
			$pipe->pipe($frontend, $this->app->make('tht.frontend.middleware'));
		}

		return $pipe;
	}

	private function pathStartsWith($path, $prefix)
	{
		return $path === $prefix || starts_with($path, "$prefix/");
	}

	protected function getInstallerMiddleware(MiddlewarePipe $pipe)
	{
		$this->app->register(InstallServiceProvider::class);

		// (Right now it tries to resolve a database connection because of the injected settings repo instance)
		// We could register a different settings repo when TheHostingTool is not installed
		//$pipe->pipe($this->app->make(HandleErrors::class, ['debug' => true]));
		$pipe->pipe($this->app->make(StartSession::class));
		$pipe->pipe($this->app->make(DispatchRoute::class, ['routes' => $this->app->make('tht.install.routes')]));

		return $pipe;
	}

	protected function getMaintenanceMiddleware(MiddlewarePipe $pipe)
	{
		$pipe->pipe(function () {
			return new HtmlResponse(file_get_contents($this->getErrorDir().'/503.html', 503));
		});

		// TODO: FOR API render JSON-API error document for HTTP 503
		return $pipe;
	}

	protected function getUpdaterMiddleware(MiddlewarePipe $pipe)
	{
		//$this->app->register(UpdateServiceProvider::class);
		$pipe->pipe($this->app->make(DispatchRoute::class, ['routes' => $this->app->make('tht.update.routes')]));

		// TODO: FOR API render JSON-API error document for HTTP 503
		return $pipe;
	}

	private function getErrorDir()
	{
		return __DIR__.'/../../error';
	}
}