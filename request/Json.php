<?php

namespace clarus\request;

class Json extends Request {

	public $json = [];

	public function __construct() {
		$this->json = json_decode(file_get_contents('php://input'), TRUE);
		if(json_last_error() > 0) {
			throw new Exception(json_last_error_msg(), json_last_error());
		}
	}	
}