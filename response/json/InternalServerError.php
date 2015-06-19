<?php

namespace clarus\response\json;

class InternalServerError extends Json {

	public function __construct(array $defaultData = []) {
		$this->setHeader('HTTP/1.1 500 Internal Server Error');
		parent::__construct($defaultData);
	}

}