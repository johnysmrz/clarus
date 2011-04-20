<?php

error_reporting(E_ALL);
ini_set('track_errors', true);
ini_set('html_errors', false);

$ini = parse_ini_file('conf/default.ini', true);

include_once 'external/firebug/FirePHP.class.php';
include_once 'external/firebug/fb.php';

session_start();

// definice cest
define('PATH', realpath($_SERVER['DOCUMENT_ROOT'] . '/../'));
define('PATH_CORE', PATH . $ini['enviroment']['core_path']);
define('PATH_TPL', PATH . $ini['enviroment']['tpl_path']);
define('PATH_TPL_C', PATH . $ini['enviroment']['tpl_compiled']);
define('PATH_LOG', $ini['enviroment']['log_path']);
define('PATH_CACHE', PATH . $ini['enviroment']['cache_path']);
define('PATH_APP', PATH . $ini['enviroment']['app_path']);
define('PATH_CONF', PATH . $ini['enviroment']['conf_path']);

define('FORM_PREFIX', $ini['enviroment']['form_prefix']);
define('URL', $ini['enviroment']['base_url']);

define('DEBUG', $ini['enviroment']['debug'] == 'TRUE' ? TRUE : FALSE);

define('DEFAULT_LOCALE', $ini['enviroment']['default_locale']);

// podpora pro gettext
if (isset($ini['gettext'])) {
    define('GETTEXT_USE', ($ini['gettext']['use'] == 'TRUE' ? TRUE : FALSE));
}