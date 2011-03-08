<?php

class form_item_Text extends form_Item {

    public function  __construct($name, $label = NULL) {
        parent::__construct('text', $name, $label);
    }

}