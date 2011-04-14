<?php

namespace clarus\ioc;

/**
 * Configuration object for beans, should not be created from outside
 * @internal
 * @author Jan Smrz
 * @package clarus
 * @subpackage ioc
 */
class BeanConfiguration {

    protected $id = NULL;
    protected $class = NULL;
    protected $args = array();
    protected $for = NULL;

    /**
     * @param string $id
     * @param string $class
     */
    public function __construct($id, $class) {
        $this->id = $id;
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getClass() {
        return $this->class;
    }

    /**
     * @return array
     */
    public function getArgs() {
        \ksort($this->args);
        return $this->args;
    }

    /**
     * Add argument
     * @param mixed $index
     * @param string $value
     */
    public function addArg($index, $value) {
        if ($index === NULL) {
            $this->args[] = $value;
        } else {
            $this->args[$index] = $value;
        }
    }

    /**
     * @return string
     */
    public function getFor() {
        return $this->for;
    }

    /**
     * @param string $for
     */
    public function addFor($for) {
        $this->for[] = $for;
    }

}