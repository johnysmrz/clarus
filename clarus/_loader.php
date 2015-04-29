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

$clarus = new Clarus();