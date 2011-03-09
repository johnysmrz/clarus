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
    }

    final private function getHtmlName() {
        if ($this->form instanceof form_Form) {
            return 'form[' . $this->form->getName() . '][' . $this->getName() . ']';
        } else {
            return $this->getName();
        }
    }

    final private function getHtmlId() {
        if ($this->form instanceof form_Form) {
            return 'form_' . $this->form->getName() . '_' . $this->getName();
        } else {
            return $this->getHtmlName();
        }
    }

    public function processItem() {
        if (!($this->form instanceof form_Form)) {
            throw new LogicException('Standalone item cannot be processed', 1);
        }
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