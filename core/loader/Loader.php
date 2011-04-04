<?php

namespace clarus\loader;

/**
 * Abstract class for creating future loaders wich will be registered to spl autoloader
 * @author Jan Smrz
 * @package clarus
 * @subpackage loader
 */
abstract class Loader {

    final public function __construct() {
        spl_autoload_register(array($this, 'load'));
        $this->onCreate();
    }

    /**
     * This function will be registered as autoloading function when is new loader created
     * @param string $class Class to be loaded
     */
    abstract protected function load($class);

    /**
     * Function called after construct
     */
    protected function onCreate() {
        //empty
    }

    final public function __destruct() {
        spl_autoload_unregister(array($this, 'load'));
    }

}