<?php

abstract class presenter_Presenter {

    /*
     * @param View
     */
    protected $view = NULL;

    final public function  __construct($action = NULL, $param = NULL) {
        $this->view = View::getInstance();
        if($action === NULL) $action = 'default';
        if(method_exists($this, '_'.$action.'Action')) {
            $this->_initialize();
            $this->{'_'.$action.'Action'}($param);
            $this->_deInitialize();
        } else {
            throw new presenter_Exception('Action ['.$action.'] not exists', 1);
        }
    }

    abstract protected function _defaultAction();

    abstract protected function _initialize();

    abstract protected function _deInitialize();
    
}