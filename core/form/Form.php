<?php

class form_Form implements IDisplayable {

    protected $name = NULL;
    protected $items = array();
    protected $method = 'post';
    protected $action = NULL;

    public function __construct($name, $method = 'post', $action = NULL) {
        $this->name = $name;
        $this->method = $method;
        $this->action = $action;
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

    public function getMethod() {
        return $this->method;
    }

    public function getAction() {
        return $this->action;
    }

    public function processForm($item = NULL) {
        foreach ($this->items as $name => $item) {
            
        }
    }

}