<?php

class security_BackendUser implements \clarus\security\autentification\IBackendUser {

    protected $username = NULL;

    public function  __construct($username) {
        $this->username = $username;
    }

    public function getUsername() {
        return $this->username;
    }
}