<?php

abstract class loader_Abstract {

    public function __construct() {
        spl_autoload_register(array($this, 'load'));
    }

    abstract protected function load($class);

    final public function __destruct() {
        spl_autoload_unregister(array($this, 'load'));
    }

}