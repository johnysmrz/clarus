<?php

namespace clarus\response\xml;

class Ok extends Xml {

	public function __construct() {
		$this->setHeader('HTTP/1.1 200 OK');
		parent::__construct();
	}

}