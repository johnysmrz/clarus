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
            i18n_Locale::getInstance()->setLocale($values['lang']);
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
        $form->addItem(new form_item_Text('username', array(form_Item::LABEL => _('username'))));
        $form->addItem(new form_item_Password('password', array(form_Item::LABEL => _('password'))));
        $form->addItem(new form_item_Select('lang',
                array(
                    form_Item::SELECT_OPTIONS => array(
                        'cs_CZ.utf8' => 'česky ('._('cesky').')',
                        'en_US.utf8' => 'english ('._('anglicky').')'
                    ),
                    form_Item::DEFAULT_VALUE => i18n_Locale::getInstance()->getLocale()
                )
        ));
        $form->addItem(new form_item_Submit('submit', array(form_Item::DEFAULT_VALUE => _('login'))));
        return $form;
    }

    protected function _deInitialize() {

    }

}