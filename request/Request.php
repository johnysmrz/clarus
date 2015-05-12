<?php

namespace clarus\request;

abstract class Request {
	
	const METHOD_GET = 'get';
	const METHOD_POST = 'post';
	const METHOD_PUT = 'put';
	const METHOD_DELETE = 'delete';

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