<?php

namespace clarus\dbal;

/**
 * @todo
 */
class Query implements \Countable {

    /**
     * @var PDOStatement
     */
    protected $statement = NULL;

    /**
     * @var bool
     */
    protected $executed = FALSE;

    /**
     * @var array
     */
    protected $parameters = array();

    /**
     *
     * @param PDO $connection
     * @param string $query
     * @param array $parameters
     */
    public function __construct(PDO $connection, $query, array $parameters) {
        $this->statement = $connection->prepare($query);
        $this->parameters = $parameters;
    }

    /**
     * Vykona pokud jiz vykonano nebylo
     * @return void
     */
    public function execute() {
        if(!$this->executed) {
            $this->statement->execute($this->parameters);
            $this->executed = TRUE;
        }
    }

    /**
     * @param string $parameter
     * @param mixed $variable
     */
    public function bindValue($parameter, $variable) {
        $this->parameters[$parameter] = $variable;
    }

    /**
     * Interface countable
     * @return int
     */
    public function count() {
        $this->execute();
        return $this->statement->rowCount();
    }

    /**
     * @return array
     */
    public function fetch() {
        $this->execute();
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }


}