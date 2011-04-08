<?php

namespace clarus\router;

/**
 * Homepage router can handle only URL without any path, aka. homepage
 * @author Jan Smrz
 * @package clarus
 * @subpackage router
 */
class HomepageRouter extends Router {

    /**
     * @param string $presenter
     * @param string $action
     * @param string $param
     * @param array $flags
     */
    public function __construct($presenter, $action = NULL, $param = NULL, $flags = NULL) {
        parent::__construct($flags);
        $this->setPresenter($presenter);
        $this->setAction($action);
        $this->setParam($param);
    }

    /**
     * @return bool
     */
    public function match() {
        if ('/' == $_SERVER['REQUEST_URI']) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}