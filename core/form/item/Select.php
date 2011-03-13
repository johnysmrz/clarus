<?php

class form_item_Select extends form_Item {

    protected $selectOptions = array();

    protected function setup($options = NULL) {
        if(isset($options[self::SELECT_OPTIONS])) {
            $this->selectOptions = $options[self::SELECT_OPTIONS];
        }
        $this->type = 'text';
    }

    public function  display($return = FALSE) {
        include(PATH_TPL . '/system/form/select.php');
    }

}