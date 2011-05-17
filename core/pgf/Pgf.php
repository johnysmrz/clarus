<?php

namespace clarus\pgf;

use clarus\ioc\Container as IocContainer;

/**
 * @license http://www.gnu.org/copyleft/gpl.html
 * @author Jan Smrz <jan-smrz@jan-smrz.cz>
 * @package clarus
 * @subpackage pgf
 */
abstract class Pgf implements \clarus\ioc\IInjectable {

    /**
     * @IocInject('dbconn')
     * @var Closure(PDO)
     */
    protected $connection = NULL;

    public function __construct() {
        IocContainer::inject($this);
    }

    /**
     * @param string $name
     * @param mixed $arguments
     * @return \PDOStatement
     */
    public function __call($name, $arguments) {
        $conn = $this->connection;
        $conn = $conn();

        foreach ($arguments as &$value) {
            $value = $this->resolveArgument($value);
        }

        $qs = 'SELECT * FROM ' . $name . '(' . (implode(',', $arguments)) . ')';
        if(defined('DEBUG') && DEBUG) {
            trigger_error($qs, E_USER_NOTICE);
        }
        $q = $conn->query($qs);
        $err = $conn->errorInfo();
        if ($err[0] !== '00000') {
            /**
             * @todo specificke vyjimky
             */
            switch ($err[0]) {
                case '42883':
                    throw new FunctionNotFound($err);
                default:
                    throw new \clarus\DBException($err);
            }
        }
        return new Result($q);
    }

    protected function resolveArgument($arg, $flag = NULL) {
        switch (gettype($arg)) {
            case 'integer':
                return $this->convertInt($arg);
            case 'array':
                return $this->convertArray($arg, $flag);
            case 'boolean':
                return $this->convertBool($arg);
            case 'string':
                return $this->convertString($arg);
            case 'double':
                return $this->convertDouble($arg);
            default:
                throw new \LogicException('Unknown argument type [' . gettype($arg) . ']', 1);
        }
    }

    protected function convertDouble($double) {
        return sprintf('%F', $double);
    }

    protected function convertBool($bool) {
        return $bool ? 'TRUE' : 'FALSE';
    }

    protected function convertString($string) {
        return '"' . $string . '"';
    }

    protected function convertInt($int) {
        return "$int";
    }

    protected function convertArray(array $array, $depth = 0) {
        $depth++;
        $rtn = array();
        foreach ($array as $value) {
            $rtn[] = $this->resolveArgument($value, $depth);
        }
        $depth--;
        return ($depth ? '' : 'ARRAY') . '[' . implode(',', $rtn) . ']';
    }

}