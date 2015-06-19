<?php

namespace clarus\response\html;

class Ok extends Html {

	public function __construct($templater = NULL) {
		$this->setHeader('HTTP/1.1 200 OK');
		parent::__construct($templater);
	}

}