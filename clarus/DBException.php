<?php

namespace clarus;

/**
 * @license http://www.gnu.org/copyleft/gpl.html
 * @author Jan Smrž <jan-smrz@jan-smrz.cz>
 * @package clarus
 */
class DBException extends Exception {

    protected $sqlCode = NULL;

    public function __construct(array $err) {
        $this->sqlCode = $err[0];
        parent::__construct($err[2],$err[1]);
    }
    
    final public function getSqlCode() {
        return $this->sqlCode;
    }

}