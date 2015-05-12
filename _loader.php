<?php

namespace clarus;

/**
 * Clarus core bootstrap
 */

if(!(defined('\PHP_VERSION_ID') && \PHP_VERSION_ID > 50400)) {
	trigger_error(_('Clarus need PHP 5.4 or older'), E_USER_ERROR);
	exit;
}

// PSR-4 autoloader
spl_autoload_register(function ($class) {
	$cp = implode(\DIRECTORY_SEPARATOR, explode('\\', $class));
	$file = getcwd().\DIRECTORY_SEPARATOR.$cp.'.php';
	if(file_exists($file)) {
		require_once($file);
	}
});

// custom error handler
set_error_handler(function($errno, $errstr, $errfile, $errline){
	switch ($errno) {
		case \E_RECOVERABLE_ERROR:
			throw new error\RecoverableError($errstr);
			break;
		case \E_USER_ERROR:
			throw new error\UserNotice($errstr);
			break;
		case \E_USER_WARNING:
			throw new error\UserNotice($errstr);
			break;
		case \E_USER_NOTICE:
			throw new error\UserNotice($errstr);
			break;
		default:
			throw new \Exception($errstr, 1);
			break;
	}
});

$clarus = new Clarus();