<?php

class presenter_backend_Login extends presenter_Presenter {

    protected function _deInitialize() {

    }

    protected function _defaultAction() {
        $form = $this->createForm();
        $this->view->bind('form', $form);
        if ($form->processForm()) {
            $values = & $form->getValues();
            $autentificator = new security_BackendAutentificator($values['username'], $values['password']);
            $user = security_autentification_User::autentificate($autentificator);
            echo '<pre>' . print_r($user, true) . '</pre>';
            Application::redir('/admin/default');
        }
    }

    protected function _initialize() {
        View::getInstance()->setLayoutTpl(PATH_TPL . '/backend/@loginLayout.php');
    }

    protected function createForm() {
        $form = new form_Form('login', 'post');
        $form->addItem(new form_item_Text('username', 'jméno', _('Username')));
        $form->addItem(new form_item_Password('password', 'password', _('Password')));
        $form->addItem(new form_item_Submit('submit', _('Login')));
        return $form;
    }

}