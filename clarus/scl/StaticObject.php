<?php

namespace clarus\scl;

/**
 * Helper class for all static objects, defines exception in constructor
 * @author Jan Smrz
 * @package clarus
 * @subpackage scl
 * @throws LogicException
 */
class StaticObject {

    final private function __construct() {
        throw new \LogicException(_('Static object canot be instantied'), 1);
    }

}