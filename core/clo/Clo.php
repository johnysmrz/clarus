<?php

/**
 * @author Jan Smrz
 * @package Clo
 * Zakladni trida pro praci s CLO - Clarus Lightweight ORM
 * Pouze tato trida by mela byt volana z vnejsku, vsechnu obsluhu zarizuje na
 * zaklade definovanych DAO objektu a jejich metod
 */
class clo_Clo {

    /**
     * Obsahuje referenci na pripojeni do DB
     * Nemusi se pouzivat
     * @var resource
     */
    private static $connectionResource;
    private static $globalVariables = array();

    /**
     * Vraci predpripraveny vysledek dotazu pomoci parametru
     * @param string $dao Jmeno obsluzneho Dao objektu (bez Clo_Dao)
     * @param string $method Metoda obsluzneho objektu
     * @param array $params Parametry predane do obsluzne metody
     * @return Clo_ResultCollection
     */
    public static function get($dao, $method, array $params) {
        if (class_exists($dao)) {
            return new clo_ResultCollection(new $dao($method, $params));
        } else {
            throw new clo_Exception('DAO object [' . $dao . '] dose not exists', 1);
        }
    }

    public static function setGlobalVariable($key, $value) {
        if (!(self::$globalVariables instanceof clo_ParamCollection))
            self::$globalVariables = new clo_ParamCollection();
        self::$globalVariables->$key = $value;
    }

    public static function getGloabalVariables() {
        return self::$globalVariables;
    }

    public static function setConnection($resource) {
        self::$connectionResource = $resource;
    }

    public static function getConnection() {
        return self::$connectionResource;
    }

}

?>