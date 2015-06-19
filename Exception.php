<?php

namespace clarus;

/**
 * Basic clarus exception for all future subclasses used in clarus
 * This class SHOULD be override but it is not obligatory so be prepared to catch this one bastard!
 * This exception has no magic power.... except some.... ok, it is \JsonSerializable for now :)
 * @package clarus
 */
class Exception extends \Exception implements \JsonSerializable {

	/**
	 * @var array
	 */
	protected $data = [];

	/**
	 * @param string $message
	 * @param int $code
	 * @param array $data additional data associated with exception (also will be serialized as additionalData in json)
	 */
	public function __construct($message, $code = 0, array $data = []) {
        $this->data = $data;
        parent::__construct($message, $code);
    }

	/**
	 * Return additional data block
	 * @return array
	 */
	public function getData() {
        return $this->data;
    }

	/**
	 * (PHP 5 &gt;= 5.4.0)<br/>
	 * Specify data which should be serialized to JSON
	 * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 * which is a value of any type other than a resource.
	 */
	function jsonSerialize() {
		return [
			'message' => $this->getMessage(),
			'code' => $this->getCode(),
			'additionalData' => $this->getData(),
			'trace' => $this->getTrace()
		];
	}


}

?>