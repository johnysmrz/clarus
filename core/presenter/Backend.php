<?php

namespace clarus\presenter;

abstract class Backend extends Presenter {

    protected $user = NULL;

    protected function _initialize() {
        \clarus\View::getInstance()->setLayoutTpl(PATH_TPL . '/backend/@layout.php');
        $this->user = \clarus\security\autentification\User::get('\clarus\security\autentification\IBackendUser');
    }

}