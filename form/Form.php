<?php

namespace clarus\form;

/**
 * Default form class
 * @author Jan Smrz
 * @package clarus
 * @subpackage form
 */
class Form implements \clarus\IDisplayable {

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
    public function addItem(Item $item) {
        $this->items[$item->getName()] = $item;
        $item->setForm($this);
    }

    /**
     * Zobrazi formular, implementace rozhrani IDisplayable
     * @param bool $return
     */
    public function display($template = NULL) {
        include(\clarus\templater\Templater::get(PATH_TPL . (($template == NULL) ? '/system/form/form.php' : $template)));
    }

    /**
     * Vraci promenou
     * @param mixed $name
     */
    public function getTplVar($name) {
        switch ($name) {
            case 'name':
                return $this->name;
                break;
            case 'method':
                return $this->method;
                break;
            case 'action':
                return $this->action;
                break;
            case 'values':
                return $this->values;
                break;
            default:
                throw new \InvalidArgumentException('Tpl var ['.$name.'] not known', 1);
        }
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
            if ($item->processItem() === FALSE) {
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