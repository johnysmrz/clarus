<?php

namespace clarus\presenter;

/**
 * Interface for error presenter such as http/404 etc...
 * @author Jan Smrz
 * @package clarus
 * @subpackage presenter
 */
interface IErrorPresenter {

    public function _404Action();
}