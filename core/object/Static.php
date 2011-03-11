<?php

/**
 * Pomocna trida pro staticke objekty, osetruje konstruktor
 * @author Jan Smrz
 * @package main
 * @throws LogicException
 */
class object_Static {

    final private function __construct() {
        throw new LogicException(_('Static object canot be instantied'), 1);
    }

}