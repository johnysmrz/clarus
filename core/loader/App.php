<?php

namespace clarus\loader;

/**
 * Loader for app classes
 * @author Jan Smrz
 * @package clarus
 * @subpackage loader
 */
class App extends Loader {

    protected function load($class) {
        $pathParts = explode('_',$class);
        $appClass = PATH_APP . '/' . implode('/', $pathParts) . '.php';
        if (file_exists($appClass)) {
            include_once($appClass);
        }
    }

}