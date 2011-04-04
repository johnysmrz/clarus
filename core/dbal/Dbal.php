<?php

namespace clarus\dbal;

/**
 * Abstract class for all future DB connections
 * @author Jan Smrz
 * @package clarus
 * @subpackage dbal
 */
abstract class Dbal implements \clarus\IConnectable {

    /**
     * @var PDO
     */
    protected $connection = NULL;

    /**
     * Nazev databaze
     * @var string
     */
    protected $db = NULL;

    /**
     * Host databaze
     * @var string
     */
    protected $host = NULL;

    /**
     * Port databaze
     * @var string
     */
    protected $port = NULL;

    /**
     * Uzivatelske jmeno do databaze
     * @var string
     */
    protected $username = NULL;

    /**
     * Heslo do databaze
     * @var string
     */
    protected $password = NULL;

    /**
     * Parametry pro driver
     * @var array
     */
    protected $options = array();

    /**
     * @param string $db
     * @param string $host
     * @param string $username
     * @param string $password
     * @param array $options
     */
    final public function __construct($db, $host = '127.0.0.1', $username = NULL, $password = NULL, $options = array()) {
        if (strpos(':', $this->host) !== FALSE) {
            list($this->host, $this->port) = explode(':', $host, 2);
        } else {
            $this->host = $host;
            $this->port = NULL;
        }
        $this->db = $db;
        $this->username = $username;
        $this->password = $password;
        $this->options = $options;
    }

    /**
     * Vraci sestavene dns bez nazvu driveru
     * @return string
     */
    final protected function createDns() {
        $dns = 'host=' . $this->host . ';dbname=' . $this->db . ';';
        if ($this->port !== NULL) {
            $dns .= 'port=' . $this->port;
        }
        return $dns;
    }

    /**
     * Overi pripojeni k DB
     * @return bool
     */
    public function checkConnection() {
        if($this->connection instanceof PDO) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     *
     * @return dbal_Query
     */
    public function query($query) {
        if(!$this->checkConnection()) {
            $this->connect();
        }
        $args = func_get_args();
        array_shift($args);
        return new dbal_Query($this->connection, $query, $args);
    }

}