<?php

class form_Form implements IDisplayable {

    protected $name = NULL;
    protected $items = array();

    public function __construct($name) {
        $this->name = $name;
    }

    public function addItem(form_Item $item) {
        $this->items[$item->getName()] = $item;
        $item->setForm($this);
    }

    public function display($return = FALSE) {
        include(PATH_TPL . '/system/form/form.php');
    }

    public function getName() {
        return $this->name;
    }

}