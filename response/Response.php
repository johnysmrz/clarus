<?php

namespace clarus\response;

abstract class Response implements \ArrayAccess {

	const CONTENT_TYPE = 'Content-Type';

	protected $headers = [];

	protected $container = [];

	/**
	 * Set header for current request
	 * Content-Type can be also set but will be override by internal type for each type of response
	 * @param string $string
	 */
	public function setHeader($string) {
		$this->headers[] = $string;
	}

	/**
	 * Return current set of headers
	 * @return array
	 */
	public function getHeaders() {
		return $this->headers;
	}

	abstract public function getOutput();

	/**
	 * @param $filler
	 */
	public function fill($filler) {
		if (is_array($filler) || $filler instanceof \ArrayAccess) {
			$this->container = $filler;
		} else if ($filler instanceof \Iterator) {
			$this->fillIterator($filler);
		} else if ($filler instanceof \JsonSerializable) {
			$this->container = $filler;
		} else {
			throw new \UnexpectedValueException('Filler must be on of: array|ArrayAccess|Iterator|JsonSerializable');
		}
	}

	/**
	 * @param \Iterator $iterator
	 */
	public function fillIterator(\Iterator $iterator) {
		$this->container = iterator_to_array($iterator);
	}

	// ==== Implementation of ArrayAccess Interface ===

	/**
	 * Implementation of ArrayAccess interface
	 * @param mixed $offset
	 * @param mixed $value
	 */
	public function offsetSet($offset, $value) {
		if (is_null($offset)) {
			$this->container[] = $value;
		} else {
			$this->container[$offset] = $value;
		}
	}

	/**
	 * Implementation of ArrayAccess interface
	 * @param mixed $offset
	 * @return bool
	 */
	public function offsetExists($offset) {
		return isset($this->container[$offset]);
	}

	/**
	 * Implementation of ArrayAccess interface
	 * @param mixed $offset
	 */
	public function offsetUnset($offset) {
		unset($this->container[$offset]);
	}

	/**
	 * Implementation of ArrayAccess interface
	 * @param mixed $offset
	 * @return null
	 */
	public function offsetGet($offset) {
		return isset($this->container[$offset]) ? $this->container[$offset] : null;
	}
}