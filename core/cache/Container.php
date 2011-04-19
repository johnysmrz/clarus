<?php

namespace clarus\cache;

/**
 *
 * @author johny
 */
class Container implements \Serializable {

    protected $variables;

    public function __construct() {
        
    }

    public function serialize() {
        return \serialize($this->variables);
    }

    public function unserialize($serialized) {
        $this->variables = \unserialize($serialized);
    }

    public function __set($key, $value) {
        $this->variables[$key] = $value;
    }

    public function __get($key) {
        return $this->variables[$key];
    }

}