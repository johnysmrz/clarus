<?php

namespace clarus\request;

abstract class Request {
	
	const METHOD_GET = 'get';
	const METHOD_POST = 'post';
	const METHOD_PUT = 'put';
	const METHOD_DELETE = 'delete';

	/**
	 * @return \clarus\router\Router
	 */
	public function getRouter() {
		return $this->router;
	}

	/**
	 * @param \clarus\router\Router $router
	 */
	public function setRouter($router) {
		$this->router = $router;
	}

	/**
	 * @var \clarus\router\Router
	 */
	protected $router = NULL;

	public function getHttpMethod() {
		switch ($_SERVER['REQUEST_METHOD']) {
			default:
			case 'GET':
				return self::METHOD_GET;
			case 'POST':
				return self::METHOD_POST;
			case 'PUT':
				return self::METHOD_PUT;
			case 'DELETE':
				return self::METHOD_DELETE;
		}
	}


}