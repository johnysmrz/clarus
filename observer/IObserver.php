<?php

namespace clarus\observer;

/**
 * Interface IObserver
 * @package clarus\observer
 */
interface IObserver {

	/**
	 * @param Event $event
	 * @return Event
	 */
	public function __invoke(Event $event);

}