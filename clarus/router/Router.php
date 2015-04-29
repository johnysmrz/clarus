<?php

namespace clarus\router;

/**
 * @package clarus
 */
abstract class Router {

    protected $controller = 'Default';
    protected $method = 'defaultMethod';

    /**
     * @return boolean
     */
    abstract public function match();

    public function getController() {
        return $this->controller;
    }

    public function getMethod() {
        return $this->method;
    }

}