<?php

class security_BackendUser implements security_autentification_IBackendUser {

    protected $username = NULL;

    public function  __construct($username) {
        $this->username = $username;
    }

    public function getUsername() {
        return $this->username;
    }
}