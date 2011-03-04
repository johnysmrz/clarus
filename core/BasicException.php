<?php

class BasicException extends Exception {
	
	protected $data = null;
	
	public function __construct($message,$code,$data = null) {
		$this->data = $data;
		parent::__construct($message,$code);
	}
	
	public function getData() {
		return $this->data;
	}
}

?>