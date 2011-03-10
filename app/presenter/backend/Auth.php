<?php

class presenter_backend_Auth extends presenter_Presenter {

    protected function _initialize() {
        View::getInstance()->setLayoutTpl(PATH_TPL . '/backend/@loginLayout.php');
    }

    protected function _defaultAction() {
        $form = $this->createForm();
        $this->view->bind('form', $form);
        if ($form->processForm()) {
            $values = & $form->getValues();
            $autentificator = new security_BackendAutentificator($values['username'], $values['password']);
            $user = security_autentification_User::autentificate($autentificator);
            if (isset($_GET['requested'])) {
                Application::redir(base64_decode($_GET['requested']));
            } else {
                Application::redir('/admin/default');
            }
        }
    }

    protected function _loginAction() {
        $this->_defaultAction();
    }

    protected function _logoutAction() {
        security_autentification_User::logout();
        Application::redir('/admin/auth/login');
    }

    protected function createForm() {
        $form = new form_Form('login', 'post');
        $form->addItem(new form_item_Text('username', 'jméno', _('Username')));
        $form->addItem(new form_item_Password('password', 'password', _('Password')));
        $form->addItem(new form_item_Submit('submit', _('Login')));
        return $form;
    }

    protected function _deInitialize() {

    }

}