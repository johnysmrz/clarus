<?php

namespace cms;

/**
 * Clarus core bootstrap
 */

define('CLARUS_CMS_VERSION', '0.1-alpha0');
define('CLARUS_CMS_VERSION_ID', -100);

if(!(defined('CLARUS_VERSION_ID') && CLARUS_VERSION_ID <= -400)) {
    trigger_error(_('Clarus CMS needs Core version 0.4-alpha0 or older'), E_USER_ERROR);
    exit;
}

include_once('comon/Loader.php');
$loader = new Loader();