<?php

namespace clarus\router;

/**
 * Basic class for all future routers
 * @author Jan Smrz
 * @package clarus
 * @subpackage routers
 */
abstract class Router {

    protected $flags = NULL;
    protected $presenter = NULL;
    protected $action = NULL;
    protected $param = NULL;

    public function __construct($flags = NULL) {
        $this->flags = $flags;
    }

    abstract public function match();

    final public function getPresenter() {
        if ($this->presenter === NULL)
            throw new \LogicException('Presenter not defined', 1);
        return $this->presenter;
    }

    final public function setPresenter($presenter) {
        $this->presenter = $presenter;
    }

    final public function getAction() {
        return $this->action;
    }

    final public function setAction($action) {
        $this->action = $action;
    }

    final public function getParam() {
        return $this->param;
    }

    final public function setParam($param) {
        $this->param = $param;
    }

}