<?php

/**
 * Defaultni trida pro generovani formulare
 * @author Jan Smrz
 * @package form
 */
class form_Form implements IDisplayable {

    protected $name = NULL;
    protected $items = array();
    protected $method = 'post';
    protected $action = NULL;
    protected $values = array();

    /**
     * @param string $name
     * @param string $method get/post
     * @param string $action
     */
    public function __construct($name, $method = 'post', $action = NULL) {
        $this->name = $name;
        $this->method = $method;
        $this->action = $action;
    }

    /**
     * Prida polozku do formulare
     * @param form_Item $item
     */
    public function addItem(form_Item $item) {
        $this->items[$item->getName()] = $item;
        $item->setForm($this);
    }

    /**
     * Zobrazi formular, implementace rozhrani IDisplayable
     * @param bool $return
     */
    public function display($return = FALSE) {
        include(templater_Templater::get(PATH_TPL . '/system/form/form.php'));
    }

    /**
     * Vrati jmeno formulare
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Vrati metodu formulare get/post
     * @return string
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * Vraci akci formulare
     * @return string
     */
    public function getAction() {
        return $this->action;
    }

    /**
     * Zpracuje formular
     * @param string $item nazev prvku podle ktereho se ma zpracovat
     * @return boolean
     */
    public function processForm($item = NULL) {
        $status = TRUE;
        foreach ($this->items as $name => $item) {
            if($item->processItem() === FALSE) {
                $status = FALSE;
            }
            $this->values[$name] = $item->getValue();
        }
        return $status;
    }

    /**
     * Vraci pole hodnot podle indexovane podle jmena formulare
     * @return array
     */
    public function & getValues() {
        return $this->values;
    }

}