<?php

/**
 * Pomocna trida pro singleton, osetruje stavy aby byl singleton opravdu singletonem
 * @author Jan smrz
 * @package main
 * @throws LogicException
 */
abstract class object_Singleton {

    public function __clone() {
        throw new LogicException(_('Singleton canot be cloned'), 1);
    }

}