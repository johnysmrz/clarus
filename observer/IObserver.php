<?php

namespace clarus\observer;

interface IObserver {

	/**
	 * @param mixed $context
	 * @param array $payload
	 * @return mixed
	 */
	public function invoke($context, $payload = []);
}