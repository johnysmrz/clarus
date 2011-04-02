<?php

namespace clarus\dbal;

/**
 * Dbal class for PostgreSQL
 * @author Jan Smrz
 * @package clarus
 * @subpackage dbal
 */
class MySql extends Dbal implements \clarus\IConnectable {
    public function connect() {
        $this->connection = new PDO('mysql:'.$this->createDns(), $this->username, $this->password, $this->options);
    }
}