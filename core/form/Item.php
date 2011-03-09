<?php

abstract class form_Item {

    /**
     * HTML typ inputu, musi byt definovan v setUp metode potomka
     * @var string
     */
    protected $type = NULL;
    /**
     * Nazev inputu
     * @var string
     */
    protected $name = NULL;
    /**
     * Label inputu
     * @var string
     */
    protected $label = NULL;
    /**
     * Instance nadrazeneho formulare
     * @var form_Form
     */
    protected $form = NULL;
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
        switch ($this->form->getMethod()) {
            case 'get':
                if (isset($_GET['form'][$this->form->getName()][$this->getName()])) {
                    $this->value = $_GET['form'][$this->form->getName()][$this->getName()];
                    return TRUE;
                } else {
                    return FALSE;
                }

                break;
            case 'post':
                if (isset($_POST['form'][$this->form->getName()][$this->getName()])) {
                    $this->value = $_POST['form'][$this->form->getName()][$this->getName()];
                    return TRUE;
                } else {
                    return FALSE;
                }
                break;
            default:
                throw new LogicException('Unknown form method', 1);
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

    public function getValue() {
        return $this->value;
    }

}