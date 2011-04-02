<?php

namespace clarus\loader;

/**
 * Loader for core classes
 * @author Jan Smrz
 * @package clarus
 * @subpackage loader
 */
class Core extends Loader {

    protected function load($class) {
        if (substr($class, 0, 7) === 'clarus\\') {
            $pathParts = explode('\\', substr($class, 7));
            $classFile = PATH_CORE . '/' . implode('/', $pathParts) . '.php';
            if (file_exists($classFile)) {
                include_once($classFile);
            }
        }
    }

}