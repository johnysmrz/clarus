<?php

namespace clarus\cache;

abstract class Provider {

    /**
     * @var Cache
     */
    private $pool = NULL;

    abstract protected function loadContainer($namespace);

    abstract protected function saveContainer($namespace, $serialized);

    public function __construct() {
        
    }

    /**
     * Get container by given namespace, if not exist or not already persisted, create new
     * @param string $namespace
     * @return Container
     */
    final public function getContainer($namespace) {
        if (!isset($this->pool[$namespace])) {
            if (($container = $this->loadContainer($namespace)) === NULL) {
                $this->pool[$namespace] = new Container();
            } else {
                $this->pool[$namespace] = \unserialize($container);
            }
        }
        return $this->pool[$namespace];
    }

    final public function __get($key) {
        return $this->getContainer($key);
    }

    final public function __set($key, $value) {
        throw new \InvalidArgumentException('Cant set to provider', 1);
    }

    final public function __destruct() {
        foreach ($this->pool as $namespace => $pool) {
            $this->saveContainer($namespace, \serialize($pool));
        }
    }

}