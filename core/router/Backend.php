<?php

class router_Backend extends router_Router {

    protected $base = NULL;

    public function __construct($base = 'admin', $flags = NULL) {
        $this->base = $base;
        parent::__construct($flags);
    }

    public function match() {
        if (isset($_SERVER['REDIRECT_URL'])) {
            $parts = explode('/', trim($_SERVER['REDIRECT_URL'], '/'));
            if (isset($parts[0]) && $parts[0] === $this->base && isset($parts[1]) && is_string($parts[1])) {
                
                $this->setPresenter('backend_'.ucfirst($parts[1]));
                if (isset($parts[2])) {
                    $this->setAction($parts[2]);
                }
                if (isset($parts[3])) {
                    $this->setParam($parts[3]);
                }
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

}