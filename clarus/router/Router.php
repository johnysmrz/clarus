<?php

namespace clarus\router;

/**
 * @package clarus
 */
abstract class Router {

    protected $controller = NULL;
    protected $action = NULL;

    /**
     * @return boolean
     */
    abstract public function match();

    public function getController() {
        return $this->controller;
    }

    public function getAction() {
        return $this->action;
    }

}