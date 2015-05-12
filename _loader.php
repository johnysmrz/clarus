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
		case \E_ERROR:
			throw new error\Error($errstr);
		case \E_WARNING:
			throw new error\Warning($errstr);
		case \E_PARSE:
			throw new error\Parse($errstr);
		case \E_NOTICE:
			throw new error\Notice($errstr);
		case \E_CORE_ERROR:
			throw new error\CoreError($errstr);
		case \E_CORE_WARNING:
			throw new error\CoreWarning($errstr);
		case \E_COMPILE_ERROR:
			throw new error\CompileError($errstr);
		case \E_COMPILE_WARNING:
			throw new error\CompileWarning($errstr);
		case \E_USER_ERROR:
			throw new error\UserError($errstr);
		case \E_USER_WARNING:
			throw new error\UserWarning($errstr);
		case \E_USER_NOTICE:
			throw new error\UserNotice($errstr);
		case \E_STRICT:
			throw new error\Strict($errstr);
		case \E_RECOVERABLE_ERROR:
			throw new error\RecoverableError($errstr);
		case \E_DEPRECATED:
			throw new error\Deprecated($errstr);
		case \E_USER_DEPRECATED:
			throw new error\UserDeprecated($errstr);
		case \E_ALL:
			throw new error\All($errstr);
		default:
			throw new \Exception($errstr);
	}
});

$clarus = new Clarus();