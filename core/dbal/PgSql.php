<?php

class dbal_PgSql extends dbal_Abstract implements IConnectable {
    public function connect() {
        $this->connection = new PDO('pgsql:'.$this->createDns(), $this->username, $this->password, $this->options);
    }
}