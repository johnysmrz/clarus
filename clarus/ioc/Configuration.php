<?php

namespace clarus\ioc;

/**
 * Configuration object for beans, should not be created from outside
 * @internal
 * @author Jan Smrz
 * @package clarus
 * @subpackage ioc
 */
class Configuration {

    const BEHAVIOUR_NEW = 1;
    const BEHAVIOUR_SHARED = 2;
    const BEHAVIOUR_PERSISTENT = 3;

    protected $id = NULL;
    protected $class = NULL;
    protected $args = array();
    protected $for = NULL;
    protected $behaviour = 'shared';

    /**
     * @param string $id
     * @param string $class
     */
    public function __construct($id, $class, $behaviour = self::BEHAVIOUR_SHARED) {
        $this->behaviour = $behaviour;
        $this->id = $id;
        $this->class = $class;
    }

    /**
     * @return int
     */
    public function getBehaviour() {
        return $this->behaviour;
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