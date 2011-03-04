<?php

/**
 * Provides connection to database, queries and fetching
 * @version 0.1
 * @author Jan "Johny" Smrz
 * @copyright GNU/GPLv3 read licence.txt
 * @package core
 * @uses PDO
 */
class DB {

    /**
     * array of PDO connection objects
     * @var array
     */
    protected static $conn = array();
    /**
     * array of PDO connection object - links to numbered self::$conn
     *
     * @var unknown_type
     */
    protected static $namedConn = array();
    /**
     * contains actual active connection
     * @var int
     */
    protected static $active = 0;
    /**
     * contains last raw SQL send to DB
     * @var string
     */
    public $lastSql = '';

    /**
     * connect do database and create PDO object of new connection
     *
     * @param string $type type of connection (mysql,pgsql etc...)
     * @param string $host db host adress:port
     * @param string $dbname name of database to use
     * @param string $user username
     * @param string $pass password
     * @param string $name name of connection, can be used in DB::setActive() method
     * @param array $options PDO options
     * @example DB::connect('pgsql','localhost:5432','mydb','foo','bar','myConnection1',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION))
     */
    public static function connect($type, $host, $dbname, $user=null, $pass=null, $name=null, $options=null) {
        if(strpos(':', $host) !== FALSE) {
            list($host, $port) = explode(':', $host, 2);
        } else {
            $port = '5432';
        }
        $dns = $type . ':host=' . $host . ';dbname=' . $dbname . ';';
        if (isset($port)) {
            $dns .= 'port=' . $port;
        }
        $db = new PDO($dns, $user, $pass, $options);
        self::$conn[] = $db;
        if ($name != null) {
            self::$namedConn[$name] = (sizeof(self::$conn) - 1);
        }
    }

    /**
     * prepare and execute once query by passing args
     *
     * @param string $sql query string
     * @param array $args argument data
     * @return PDOStatment
     */
    public static function query() {
        $args = func_get_args();
        $sql = array_shift($args);

        $p = Profiler::start(substr($sql, 0, 100));
        self::$conn[self::$active]->lastSQL = $sql;

        $qo = self::$conn[self::$active]->prepare($sql);
        if ($qo->execute($args)) {
            Profiler::stop($p);
            return $qo;
        } else {
            $i = $qo->errorInfo();
            throw new PDOException($i[1] . $i[2], $i[0]);
        }
    }

    /**
     * Prepare sql statment for execute
     * @param string $sql
     * @return PDOStatement
     */
    public static function prepare($sql) {
        self::$conn[self::$active]->lastSQL = $sql;
        return self::$conn[self::$active]->prepare($sql);
    }

    /**
     * Execute prepared PDOStatement with arguments
     * @throws PDOException
     * @param PDOStatement $qo
     * @param array $args
     * @return PDOStatement
     */
    public static function execute(PDOStatement $qo, $args = null) {
        if ($qo->execute($args)) {
            return $qo;
        } else {
            $errInfo = $qo->errorInfo();
            throw new PDOException($errInfo[2], $errInfo[9]);
        }
    }

    /**
     * set active connection by number or by name passed in DB::connect() function
     *
     * @param string/numeric $conn
     */
    public static function setActive($conn) {
        if (is_numeric($conn)) {
            self::$active = $conn;
        } else if (is_string($conn)) {
            self::$active = self::$namedConn[$conn];
        }
    }

    /**
     * fetch row from PDOStatment object
     *
     * @param PDOStatment $q object
     * @return array
     */
    public static function fetch($q) {
        return $q->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * get last sql string from active connection
     *
     * @return string
     */
    public static function getLastSQL() {
        return self::$conn[self::$active]->lastSQL;
    }

    public static function beginTransaction() {
        self::$conn[self::$active]->beginTransaction();
    }

    public static function commit() {
        self::$conn[self::$active]->commit();
    }

}
?>