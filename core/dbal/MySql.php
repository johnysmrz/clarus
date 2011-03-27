<?php

class dbal_MySql extends dbal_Abstract implements IConnectable {
    public function connect() {
        $this->connection = new PDO('mysql:'.$this->createDns(), $this->username, $this->password, $this->options);
    }
}