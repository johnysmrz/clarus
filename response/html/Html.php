<?php

namespace clarus\response\html;

use \clarus\response\Response as Response;

abstract class Html extends Response {

	protected $templater = NULL;

	public function __construct($templater) {
		$this->templater = $templater;
		$this->setHeader(sprintf('%s: %s', Response::CONTENT_TYPE, 'text/html; charset=utf-8'));
	}

	public function getOutput() {
		//echo $this->templater->createHtmlDocument($this->container);
		return '';
		return $this->container;
	}
	
}