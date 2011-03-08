<?php

abstract class presenter_Backend extends presenter_Presenter {

    protected $user = NULL;

    protected function  _initialize() {
        View::getInstance()->setLayoutTpl(PATH_TPL . '/backend/@layout.php');
        $this->user = security_autentification_User::get('secuirty_autentification_IBackendUser');
    }

}