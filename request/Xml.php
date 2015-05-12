<?php

namespace clarus\request;

class Xml extends Request {

	public $dom = NULL;

	public function __construct() {
		$this->dom = new \DOMDocument();
		$this->dom->loadXML(file_get_contents('php://input'));
	}
}