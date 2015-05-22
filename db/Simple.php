<?php

namespace clarus\db;

class Simple {

    /**
     * @var \PDO
     */
    protected $pdo = NULL;

    public function __construct($dns, $name, $pass) {
        $this->pdo = new \PDO($dns, $name, $pass);
    }

    /**
     * @param string $sql
     * @param array $args
     */
    public function query($sql, $args = []) {
        $stm = $this->pdo->prepare($sql);
        foreach($args as $name => $value) {
            $stm->bindParam($name, $value);
        }
        $stm->execute();
    }

}