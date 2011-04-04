<?php

namespace clarus\form;

class Password extends Item {

    protected function setup($options = NULL) {
        $this->type = 'password';
    }

}