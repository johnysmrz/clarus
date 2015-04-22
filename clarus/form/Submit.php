<?php

namespace clarus\form;

class Submit extends Item implements \clarus\ioc\IInjectable {

    protected function setup($options = NULL) {
        $this->type = 'submit';
    }

}