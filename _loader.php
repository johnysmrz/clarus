<?php

/**
 * Clarus core bootstrap
 */

define('CLARUS_VERSION', '0.4-alpha0');
define('CLARUS_VERSION_ID', -400);

if(!(defined('PHP_VERSION_ID') && PHP_VERSION_ID > 50300)) {
    trigger_error(_('Clarus need PHP 5.3 and older'), E_USER_ERROR);
    exit;
}

include_once('loader/Loader.php');
include_once('loader/Core.php');
new clarus\loader\Core();