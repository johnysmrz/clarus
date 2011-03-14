<?php

class security_BackendAutentificator implements security_autentification_IAutentificator {

    protected $user = NULL;

    public function __construct($username, $password) {
        if ($username == 'admin' && $password == 'pass') {
            $this->user = new security_BackendUser($username);
        }
    }

    public function getUser() {
        return $this->user;
    }

    public function isAutentificate() {
        if ($this->user instanceof security_autentification_IBackendUser) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}