<?php

namespace clarus\scl;

class DummyTraversable implements \ArrayAccess, \Iterator {

	protected $container = array();
	protected $offset = 0;

	public function __construct(array $array = []) {
		$this->container = $array;
	}

	public function offsetExists($offset) {
		return isset($this->container[$offset]);
	}

	public function offsetGet($offset) {
		return $this->container[$offset];
	}

	public function offsetSet($offset, $value) {
		if($offset === NULL) {
			$this->container[$this->offset++] = $value;
		} else {
			$this->container[$offset] = $value;
		}
	}

	public function offsetUnset($offset) {
		unset($this->container[$offset]);
	}

	public function current() {
		return \current($this->container);
	}

	public function key() {
		return \key($this->container);
	}

	public function next() {
		\next($this->container);
	}

	public function rewind() {
		\reset($this->container);
	}

	public function valid() {
		return \key($this->container) !== null;
	}

}