<?php

namespace clarus\response\json;

class Ok extends Json {

	public function __construct(array $defaultData = []) {
		$this->setHeader('HTTP/1.1 200 OK');
		parent::__construct($defaultData);
	}

}