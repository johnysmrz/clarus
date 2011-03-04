<?php

class presenter_Default extends presenter_Presenter {
    protected function _deInitialize() {

    }

    protected function _defaultAction() {

    }

    protected function _initialize() {
        $this->view->setLayoutTpl(PATH_TPL.'/@layout.php');
    }

}