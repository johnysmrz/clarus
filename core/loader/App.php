<?php

class loader_App extends loader_Abstract {

    final public function __construct() {
        parent::__construct();
    }

    protected function load($class) {
        $pathParts = explode('_',$class);
        $appClass = PATH_APP . '/' . implode('/', $pathParts) . '.php';
        if (file_exists($appClass)) {
            include_once($appClass);
        }
    }

}