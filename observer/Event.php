<?php

namespace clarus\observer;

use clarus\scl\DummyTraversable;

class Event extends DummyTraversable {

	protected $eventName = NULL;

	/**
	 * @param string $eventName
	 * @param array $data
	 */
	public function __construct($eventName, array $data = []) {
		$this->eventName = $eventName;
		parent::__construct($data);
	}

	/**
	 * @return string
	 */
	public function getEventName() {
		return $this->eventName;
	}

}