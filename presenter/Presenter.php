<?php

namespace clarus\presenter;

/**
 * Basic presenter
 * @author Jan Smrz
 * @package clarus
 * @subpackage presenter
 */
abstract class Presenter {

    /*
     * @param View
     */
    protected $view = NULL;

    final public function  __construct($action = NULL, $param = NULL) {
        $this->view = \clarus\View::getInstance();
        if($action === NULL) $action = 'default';
        if(method_exists($this, '_'.$action.'Action')) {
            $this->_initialize();
            $this->{'_'.$action.'Action'}($param);
            $this->_deInitialize();
        } else {
            throw new Exception('Action ['.$action.'] not exists', 1);
        }
    }

    abstract protected function _defaultAction();

    abstract protected function _initialize();

    abstract protected function _deInitialize();
    
}