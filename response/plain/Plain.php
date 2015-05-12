<?php

namespace clarus\response\plain;

use \clarus\response\Response as Response;

abstract class Plain extends Response {

	public function __construct() {
		$this->setHeader(sprintf('%s: %s', Response::CONTENT_TYPE, 'text/plain; charset=utf-8'));
	}

	public function getOutput() {
		return var_dump($this->container);
	}
	
}