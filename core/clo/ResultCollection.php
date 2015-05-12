<?php

/**
 * @author Jan Smrz
 * @version 1.0
 * @package Clo
 * @throws LogicException
 * Trida pro obsluhu vysledku dotazu
 * Lze s ni operovat jako s polem, pouziva opozdene (Lazy) nahravani dat z DAO objektu
 */
final class clo_ResultCollection implements Iterator, ArrayAccess {

    /**
     * @var object Odkaz na Dao objekt ktery poskytuje data
     */
    private $dao = null;
    /**
     * @var int Aktualni pozice kurzoru v poly container
     */
    private $key = null;
    /**
     * @var array Pole vysledku dotazu vracene z DAO objektu
     */
    private $container = array();
    /**
     * @var bool Indikuje jestli byl proveden pokus o nahrani dat
     */
    private $isLoaded = false;

    /**
     * @param clo_IDao $dao Instance DAO objektu ktery poskytuje data
     */
    public function __construct(clo_IDao $dao) {
        $this->dao = $dao;
    }

    /**
     * Funkce ktera prinuti natazeni kolekce aniz by bylo pozadano o cteni nebo iteraci
     * Hodi se vicemene pouze pro debug ucely
     */
    public function forceLoad() {
        $this->loadData();
    }

    /**
     * Implementace Iterable rozhrani
     * @see http://php.net/manual/en/class.iterator.php
     * @return Clo_Entry
     */
    public function current() {
        return $this->container[$this->key];
    }

    /**
     * Implementace Iterable rozhrani
     * @see http://php.net/manual/en/class.iterator.php
     * @return int
     */
    public function key() {
        return $this->key;
    }

    /**
     * Implementace Iterable rozhrani
     * @see http://php.net/manual/en/class.iterator.php
     * @return void
     */
    public function next() {
        $this->loadData();
        ++$this->key;
    }

    /**
     * Implementace Iterable rozhrani
     * @see http://php.net/manual/en/class.iterator.php
     * @return void
     */
    public function rewind() {
        $this->key = 0;
    }

    /**
     * Implementace Iterable rozhrani
     * @see http://php.net/manual/en/class.iterator.php
     * @return bool
     */
    public function valid() {
        return isset($this->container[$this->key]);
    }

    /**
     * Implementace ArrayAccess rozhrani
     * Vzdy vyhodi vyjimku!
     * @see http://www.php.net/manual/en/class.arrayaccess.php
     * @return void
     * @throws LogicException
     */
    public function offsetSet($offset, $value) {
        throw new LogicException('ResultCollection is not writable', 1);
    }

    /**
     * Implementace ArrayAccess rozhrani
     * @see http://www.php.net/manual/en/class.arrayaccess.php
     * @return bool
     */
    public function offsetExists($offset) {
        $this->loadData();
        return isset($this->container[$offset]);
    }

    /**
     * Implementace ArrayAccess rozhrani
     * Vzdy vyhodi vyjimku!
     * @see http://www.php.net/manual/en/class.arrayaccess.php
     * @return void
     * @throws LogicException
     */
    public function offsetUnset($offset) {
        throw new LogicException('ResultCollection is not deletable', 1);
    }

    /**
     * Implementace ArrayAccess rozhrani
     * @see http://www.php.net/manual/en/class.arrayaccess.php
     * @return Clo_Entity
     * @throws LogicException
     */
    public function offsetGet($offset) {
        $this->loadData();
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Nahraje data z DAO objektu
     */
    private function loadData() {
        if ($this->isLoaded === FALSE) {
            $this->container = & $this->dao->getCollection();
            $this->isLoaded = TRUE;
        }
    }

}

?>