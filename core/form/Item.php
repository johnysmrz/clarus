<?php

abstract class form_Item {

    protected $type = NULL;
    protected $name = NULL;
    protected $label = NULL;
    protected $id = NULL;

    public function __construct($type, $name, $label = NULL) {
        $this->type = $type;
        $this->name = $name;
        $this->label = $label;
    }

    public function getType() {
        return $this->type;
    }

    public function getName() {
        return $this->name;
    }

    public function getLabel() {
        return $this->label;
    }

    public function display($return = FALSE) {
        include(PATH_TPL . '/system/form/item.php');
    }

}