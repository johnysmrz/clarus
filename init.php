<?php

error_reporting(E_ALL);
ini_set('track_errors',true);
ini_set('html_errors',false);

$ini = parse_ini_file('default.ini',true);

session_start();

// definice cest
define('PATH', realpath($_SERVER['DOCUMENT_ROOT'].'/../'));
define('PATH_CORE',PATH.$ini['enviroment']['core_path']);
define('PATH_TPL',PATH.$ini['enviroment']['tpl_path']);
define('PATH_TPL_C',PATH.$ini['enviroment']['tpl_compiled']);
define('PATH_LOG',$ini['enviroment']['log_path']);
define('PATH_CACHE',PATH.$ini['enviroment']['cache_path']);
define('PATH_APP',PATH.$ini['enviroment']['app_path']);

define('FORM_PREFIX',$ini['enviroment']['form_prefix']);
define('URL',$ini['enviroment']['base_url']);

define('DEFAULT_LOCALE', $ini['enviroment']['default_locale']);

// podpora pro gettext
if(isset($ini['gettext'])) {
    define('GETTEXT_USE', ($ini['gettext']['use'] == 'TRUE' ? TRUE : FALSE));
}

function __autoload($class) {
	$pathParts = explode('_',$class);
        $coreClass = PATH_CORE.'/'.implode('/',$pathParts).'.php';
        $appClass = PATH_APP.'/'.implode('/',$pathParts).'.php';
        if(file_exists($coreClass)) {
            include_once($coreClass);
        } else if(file_exists($appClass)) {
            include_once($appClass);
        }
}

function CErrorHander($errno, $errstr) {
    switch ($errno) {
        case E_NOTICE:
            echo '<pre>' . print_r($errstr, true) . '</pre>';
            break;
        default:
            throw new scl_ErrorException($errstr, $errno);
    }
}

set_error_handler('CErrorHander');