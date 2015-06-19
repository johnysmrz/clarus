<?php

namespace clarus\response\json;

class NotAcceptable extends Json {

	public function __construct(array $defaultData = []) {
		$this->setHeader('HTTP/1.1 406 Not Acceptable');
		parent::__construct($defaultData);
	}

}