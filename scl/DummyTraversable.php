<?php

namespace clarus\scl;

class DummyTraversable implements \ArrayAccess, \Iterator {

	protected $array = array();
	protected $offset = 0;

	public function __construct(array $array = []) {
		$this->array = $array;
	}

	public function offsetExists($offset) {
		return isset($this->array[$offset]);
	}

	public function offsetGet($offset) {
		return $this->array[$offset];
	}

	public function offsetSet($offset, $value) {
		if($offset === NULL) {
			$this->array[$this->offset++] = $value;
		} else {
			$this->array[$offset] = $value;
		}
	}

	public function offsetUnset($offset) {
		unset($this->array[$offset]);
	}

	public function current() {
		return $this->array[$this->offset];
	}

	public function key() {
		return $this->offset;
	}

	public function next() {
		$this->offset++;
	}

	public function rewind() {
		$this->offset = 0;
	}

	public function valid() {
		return isset($this->array[$this->offset]);
	}

}