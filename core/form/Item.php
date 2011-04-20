<?php

namespace clarus\form;

abstract class Item implements \clarus\ioc\IInjectable {
    const DEFAULT_VALUE = 1;
    const LABEL = 2;
    const SELECT_OPTIONS = 3;

    const CHECK_FILLED = '~.+~';
    const CHECK_EMAIL = '~^[a-zA-Z0-9-_\.]+@[a-zA-Z0-9-_\.]+\.[a-z]{1,5}$~';

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
    protected $checks = array();
    protected $failMessages = array();

    final public function __construct($name, $options = NULL) {
        $this->setup($options);
        $this->id = $this->name = $name;
        if (isset($options[self::DEFAULT_VALUE])) {
            $this->value = $options[self::DEFAULT_VALUE];
        }
        if (isset($options[self::LABEL])) {
            $this->label = $options[self::LABEL];
        }
    }

    final public function setForm(Form $form) {
        $this->form = $form;
    }

    /**
     * @internal
     * @return string
     */
    final public function getHtmlName() {
        if ($this->form instanceof Form) {
            return 'form[' . $this->form->getName() . '][' . $this->getName() . ']';
        } else {
            return $this->getName();
        }
    }

    /**
     * @internal
     * @return string
     */
    final public function getHtmlId() {
        if ($this->form instanceof Form) {
            return 'form_' . $this->form->getName() . '_' . $this->getName();
        } else {
            return $this->getHtmlName();
        }
    }

    /**
     * @internal
     */
    public function processItem() {
        if (!($this->form instanceof Form)) {
            throw new LogicException('Standalone item cannot be processed', 1);
        }
        switch ($this->form->getMethod()) {
            case 'get':
                if (isset($_GET['form'][$this->form->getName()][$this->getName()])) {
                    $this->value = $_GET['form'][$this->form->getName()][$this->getName()];
                } else {
                    return FALSE;
                }
                break;
            case 'post':
                //var_dump($_POST);
                if (isset($_POST['form'][$this->form->getName()][$this->getName()])) {
                    $this->value = $_POST['form'][$this->form->getName()][$this->getName()];
                } else {
                    return FALSE;
                }
                break;
            default:
                throw new LogicException('Unknown form method', 1);
        }
        foreach ($this->checks as $regexp => $failMessage) {
            if (!\preg_match($regexp, $this->value)) {
                $this->failMessages[] = $failMessage;
            }
        }
        if(\sizeof($this->failMessages) === 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    abstract protected function setup($options = NULL);

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
        include(\clarus\templater\Templater::get(PATH_TPL . '/system/form/item.php'));
    }

    public function getValue() {
        return $this->value;
    }

    public function addCheck($regexp, $failMessage) {
        $this->checks[$regexp] = $failMessage;
        return $this;
    }

    public function getFailMessages() {
        return $this->failMessages;
    }

}