<?php

namespace clarus\form;

class Text extends Item implements \clarus\ioc\IInjectable {

    protected function setup($options = NULL) {
        $this->type = 'text';
    }

}