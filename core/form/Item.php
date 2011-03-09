<?php

abstract class form_Item {

    protected $type = NULL;
    protected $name = NULL;
    protected $label = NULL;
    protected $form = NULL;
    protected $id = NULL;
    protected $defaultValue = NULL;
    protected $value = NULL;

    final public function __construct($name, $defaultValue = NULL, $label = NULL) {
        $this->setup();
        $this->id = $this->name = $name;
        $this->label = $label;
        $this->value = $defaultValue;
    }

    final public function setForm(form_Form $form) {
        $this->form = $form;
        $this->createName();
        $this->createId();
    }

    final private function createName() {
        $this->name = 'form[' . $this->form->getName() . '][' . $this->name . ']';
    }

    final private function createId() {
        $this->id = 'form_' . $this->form->getName() . '_' . $this->id;
    }

    abstract protected function setup();

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