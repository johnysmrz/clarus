<?php

class form_Form implements IDisplayable {

    protected $name = NULL;
    protected $items = array();

    public function  __construct($name) {
        $this->name = $name;
    }

    public function addItem($item) {
        
    }

    public function display($return = FALSE) {
        
    }

}