<?php

namespace clarus\service;

class Service implements \ArrayAccess {

    /**
     * @var Service|null
     */
	protected static $instance = NULL;

    /**
     * @var array
     */
	protected $container = array();

    /**
     * @return Service
     */
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