<?php

namespace cms;

class BackendAutentificator implements \clarus\security\autentification\IAutentificator {

    protected $user = NULL;

    public function __construct($username, $password) {
        if ($username == 'admin' && $password == 'pass') {
            $this->user = new BackendUser($username);
        }
    }

    public function getUser() {
        return $this->user;
    }

    public function isAutentificate() {
        if ($this->user instanceof \clarus\security\autentification\IBackendUser) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}