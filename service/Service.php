<?php

namespace clarus\service;

class Service implements \ArrayAccess {
	
	protected static $instance = NULL;

	protected $container = array();

	public static function i() {
		if (!(self::$instance instanceof Service)) {
			self::$instance = new Service();
		}
		return self::$instance;
	}

	protected function __construct() {}

	public function offsetExists($offset) {
		return isset($this->container[$offset]);
	}

	public function offsetGet($offset) {
		return $this->container[$offset];
	}

	public function offsetSet($offset, $value) {
		$this->container[$offset] = $value;
	}

	public function offsetUnset($offset) {
		unset($this->container[$offset]);
	}

}