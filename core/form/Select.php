<?php

namespace clarus\form;

class Select extends Item implements \clarus\ioc\IInjectable {

    protected $selectOptions = array();

    protected function setup($options = NULL) {
        if(isset($options[self::SELECT_OPTIONS])) {
            $this->selectOptions = $options[self::SELECT_OPTIONS];
        }
        $this->type = 'text';
    }

    public function  display($return = FALSE) {
        include(\clarus\templater\Templater::get(PATH_TPL . '/system/form/select.php'));
    }

}