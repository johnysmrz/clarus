<?php

namespace clarus\response\xml;

use \clarus\response\Response as Response;

abstract class Xml extends Response {

	public function __construct() {
		$this->setHeader(sprintf('%s: %s', Response::CONTENT_TYPE, 'text/plain; charset=utf-8'));
	}

	public function getOutput() {
		ob_start();
		echo '<root>';
		echo '</root>';
		return ob_get_clean();
	}

	protected function arr2xml(array $arr) {
		
	}
	
}