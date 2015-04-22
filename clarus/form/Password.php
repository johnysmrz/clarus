<?php

namespace clarus\form;

class Password extends Item implements \clarus\ioc\IInjectable {

    protected function setup($options = NULL) {
        $this->type = 'password';
    }

}