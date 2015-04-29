<?php

namespace clarus;

/**
 * Basic class for running application, should be called only staticaly
 */
class Application {

	private static $instance = NULL;

	protected $routers = [];
	protected $response = NULL;

	public static function i() {
		if(!(self::$instance instanceof Application)) {
			self::$instance = new Application();
		}
		return self::$instance;
	}

	protected function __construct() {

	}

	public function run() {
		$router = $this->getValidRouter();
		if($router instanceof router\Router) {
			$this->response = $this->callRouter($router);
		} else {
			throw new \LogicException('No router found');
		}
	}

	protected function getValidRouter() {
		foreach ($this->routers as $router) {
			if($router->match()) {
				return $router;
			}
		}	
	}

	protected function createRequest() {
		return new request\NoType();
	}

	protected function callRouter(router\Router $router) {
		$cls = $router->getController();
		$mtd = $router->getMethod();
		if(class_exists($cls)) {
			$controller = new $cls();
			if(method_exists($controller, $mtd)) {
				$controller->init();
				return $controller->$mtd($this->createRequest());
			} else {
				throw new \LogicException(sprintf('Method [%s] on controller [%s] not found!', $mtd, $cls));
			}
		} else {
			throw new \LogicException(sprintf('Controller class [%s] not found!', $cls));
		}
	}

	public function addRouote(router\Router $router) {
		$this->routers[] = $router;
	}

	public function display() {
		\header(sprintf('X-Powered-By: PHP/%s; Clarus-Framework/%s', \phpversion(), Clarus::VERSION));
		if($this->response instanceof \clarus\response\Response) {
			foreach ($this->response->getHeaders() as $header) {
				\header($header);
			}
			echo $this->response->getOutput();
		} else {
			throw new \LogicException(sprintf('No response!'));
		}
	}
}