<?php

namespace clarus\response;

abstract class Response implements \ArrayAccess {

	const CONTENT_TYPE = 'Content-Type';
	
	protected $headers = [];

	protected $container = array();

	public function setHeader($string) {
		$this->headers[] = $string;
	}

	public function getHeaders() {
		return $this->headers;
	}

	abstract public function getOutput();

	public function offsetSet($offset, $value) {
		if (is_null($offset)) {
			$this->container[] = $value;
		} else {
			$this->container[$offset] = $value;
		}
	}

	public function offsetExists($offset) {
		return isset($this->container[$offset]);
	}

	public function offsetUnset($offset) {
		unset($this->container[$offset]);
	}

	public function offsetGet($offset) {
		return isset($this->container[$offset]) ? $this->container[$offset] : null;
	}

	public function fill(array $arr) {
		$this->container = $arr;
	}

}