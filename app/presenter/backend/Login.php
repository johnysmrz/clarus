<?php

class presenter_backend_Login extends presenter_Presenter {

    protected function _deInitialize() {

    }

    protected function _defaultAction() {
        $this->view->bind('form', $this->createForm());
    }

    protected function _initialize() {
        View::getInstance()->setLayoutTpl(PATH_TPL . '/backend/@loginLayout.php');
    }

    protected function createForm() {
        $form = new form_Form('login');
        $form->addItem(new form_item_Text('username',_('Username')));
        return $form;
    }

}