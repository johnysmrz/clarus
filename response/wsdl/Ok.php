<?php

namespace clarus\response\wsdl;

class Ok extends Wsdl {

	public function __construct() {
		$this->setHeader('HTTP/1.1 200 OK');
		parent::__construct();
	}

}