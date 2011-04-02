<?php

namespace clarus\dbal;

/**
 * Dbal class for PostgreSQL
 * @author Jan Smrz
 * @package clarus
 * @subpackage dbal
 */
class PgSql extends Dbal implements \clarus\IConnectable {
    public function connect() {
        $this->connection = new PDO('pgsql:'.$this->createDns(), $this->username, $this->password, $this->options);
    }
}