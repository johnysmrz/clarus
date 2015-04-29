<?php

namespace claruscms\controller;

use clarus\response\json\Ok as JsonOk;
use clarus\response\html\Ok as HtmlOk;

class Test extends \clarus\controller\Controller {

	protected $templater = NULL;

	public function init() {
		$this->templater = new \clarus\templater\XML(file_get_contents('tpl/index.xml'));
	}

	public function defaultMethod($request) {
		$response = new JsonOk();
		$response['abc'] = 1;
		$response['def'] = 'def123';
		return $response;
	}

	public function htmlMethod($request) {
		$response = new HtmlOk($this->templater);
		$response['abc'] = 1;
		$response['def'] = 'def123';
		return $response;
	}
	
}