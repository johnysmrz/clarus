<?php

namespace clarus\scl;

/**
 * Helper class for singleton classes, avoid cloning by throwing LogicException
 * @author Jan smrz
 * @package clarus
 * @subpackage scl
 * @throws LogicException
 */
abstract class SingletonObject {

    public function __clone() {
        throw new \LogicException(_('Singleton canot be cloned'), 1);
    }

}