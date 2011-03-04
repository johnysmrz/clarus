<?php

/**
 * @author Jan Smrz
 * @package Clo
 * Abstraktni trida pro tvorbu Prepravek vystupni kolekce
 * Musi se jeste docela vylepsit :-/
 */
abstract class clo_Entity {

    protected $data = array();
    private $mapper = null;

    final public function __construct($data, clo_Mapper $mapper) {
        $this->data = $data;
        $this->mapper = $mapper;
    }

    /**
     * Setter
     * @param string $key
     * @param mixed $value
     */
    final public function & __set($key, $value) {
        $this->data[$key] = $value;
    }

    /**
     * Getter
     * @param string $key
     * @return mixed
     */
    final public function __get($key) {
        return $this->mapper->evalAttribute($key, $this->data);
    }

}

?>