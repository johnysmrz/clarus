<?php

namespace clarus\response\plain;

class Ok extends Plain {

	public function __construct() {
		$this->setHeader('HTTP/1.1 200 OK');
		parent::__construct();
	}

}