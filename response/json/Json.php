<?php

namespace clarus\response\json;

use \clarus\response\Response as Response;

abstract class Json extends Response {

	public function __construct() {
		$this->setHeader(sprintf('%s: %s', Response::CONTENT_TYPE, 'application/json; charset=utf-8'));
	}

	public function getOutput() {
		return json_encode($this->container);
	}
	
}