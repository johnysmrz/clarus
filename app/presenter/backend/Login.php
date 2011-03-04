<?php

class presenter_backend_Login extends presenter_Presenter {

    protected function _deInitialize() {

    }

    protected function _defaultAction() {
        
    }

    protected function _initialize() {
        View::getInstance()->setLayoutTpl(PATH_TPL . '/backend/@layout.php');
    }

}