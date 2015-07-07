<?php

namespace clarus;

use clarus\observer\Event;

/**
 * Basic class for running application, should be called only staticaly
 */
class Application {

	/**
	 * @var Application
	 */
	private static $instance = NULL;

	protected $routers = [];
	protected $response = NULL;
	protected $requestClasses = [];
	protected $observers = [];

	/**
	 * @return Application
	 */
	public static function i() {
		if (!(self::$instance instanceof Application)) {
			self::$instance = new Application();
		}
		return self::$instance;
	}

	protected function __construct() {
		// register internall request options
		$this->registerRequest(['application/json'], sprintf('\\%s\\%s', __NAMESPACE__, 'request\Json'));
		$this->registerRequest(['application/xml', 'text/xml'], sprintf('\\%s\\%s', __NAMESPACE__, 'request\Xml'));
	}

	/**
	 * @observer clarus.application.beforeRun
	 * @observer clarus.application.afterRun
	 */
	public function run() {
		try {
			$this->invokeObservers(new observer\Event('clarus.application.beforeRun'));
			$router = $this->getValidRouter();
			if ($router instanceof router\Router) {
				$this->response = $this->callRouter($router);
			} else {
				throw new \LogicException('No router found');
			}
		} catch (\Exception $e) {
			throw $e;
		} finally {
			$this->invokeObservers(new observer\Event('clarus.application.afterRun', [
				'response' => $this->response,
				'request' => $this->createRequest(),
				'exception' => isset($e) ? $e : NULL
			]));
		}
	}

	/**
	 * @return router\Router
	 */
	protected function getValidRouter() {
		foreach ($this->routers as $router) {
			if ($router->match()) return $router;
		}
	}

	/**
	 * @return request\*
	 */
	protected function createRequest() {
		if (isset($_SERVER['CONTENT_TYPE'])) {
			$r = explode(';', $_SERVER['CONTENT_TYPE']);
			foreach ($this->requestClasses as $ct => $cls) {
				if (isset($r[0]) && $ct == $r[0]) {
					return new $cls();
				}
			}
		}
		return new request\NoType();
	}

	/**
	 * @param router\Router $router
	 * @return mixed
	 * @throws \LogicException
	 * @observer clarus.application.beforeCallRouter
	 * @observer clarus.application.beforeValidMethodCall
	 */
	protected function callRouter(router\Router $router) {
		$cls = $router->getController();
		$mtd = $router->getMethod();
		if (class_exists($cls)) {
			$controller = new $cls();
			if (method_exists($controller, $mtd)) {
				$request = $this->createRequest();
				$request->setRouter($router);
				$controller->init($request);
				return $controller->$mtd($request);
			} else {
				throw new \LogicException(sprintf('Method [%s] on controller [%s] not found!', $mtd, $cls));
			}
		} else {
			throw new \LogicException(sprintf('Controller class [%s] not found!', $cls));
		}
	}

	/**
	 * @param router\Router $router
	 */
	public function addRoute(router\Router $router) {
		$this->routers[] = $router;
	}

	/**
	 * @param response\Response|NULL $responseOverride
	 */
	public function display(response\Response $responseOverride = NULL) {
		if ($responseOverride !== NULL) {
			$this->response = $responseOverride;
		}
		if ($this->response instanceof \clarus\response\Response) {
			if (!headers_sent()) {
				\header(sprintf('X-Powered-By: PHP/%s; Clarus-Framework/%s', \phpversion(), Clarus::VERSION));
				foreach ($this->response->getHeaders() as $header) {
					\header($header);
				}
				//\header('Content-Type: text/html');
			}
			echo $this->response->getOutput();
		} else {
			throw new \LogicException(sprintf('No response!'));
		}
	}

	/**
	 * @param array $contentType
	 * @param $requestClass
	 */
	public function registerRequest(array $contentType, $requestClass) {
		foreach ($contentType as $ct) {
			$this->requestClasses[$ct] = $requestClass;
		}
	}

	/**
	 * @param array $eventNames
	 * @param observer\IObserver $observer
	 */
	public function addObserver(array $eventNames, observer\IObserver $observer) {
		foreach ($eventNames as $ename) {
			if (!isset($this->observers[$ename])) {
				$this->observers[$ename] = [];
			}
			$this->observers[$ename][] = $observer;
		}
	}

	/**
	 * Invoke all observers bound to event
	 * @param Event $event
	 */
	public function invokeObservers(observer\Event $event) {
		if (isset($this->observers[$event->getEventName()])) {
			foreach ($this->observers[$event->getEventName()] as $observer) {
				/** @var $observer observer\IObserver */
				$observer($event);
			}
		}
	}
}