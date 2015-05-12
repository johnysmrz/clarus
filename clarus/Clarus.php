<?php

namespace clarus;

/**
*
*/
final class Clarus {
	
	const VERSION = '0.5.0-alpha';
	const VERSION_ID = -400;

	public function getVersionArray() {
		preg_match('/([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})(-[a-zA-Z0-9]+)?/', self::VERSION, $m);
		return ['major' => $m[1], 'minor' => $m[2], 'build' => $m[3], 'revision' => isset($m[4]) ? $m[4] : NULL];
	}

}