<?php

class clo_ParamCollection {

    protected $data = array();

    public function __construct(array $data = array()) {
        $this->data = $data;
    }

    /**
     * Getter
     * @param string $key
     * @return mixed
     */
    final public function __get($key) {
        return $this->data[$key];
    }

    /**
     * Setter
     * @param string $key
     * @param mixed $value
     */
    final public function & __set($key, $value) {
        $this->data[$key] = $value;
    }

}

?>
