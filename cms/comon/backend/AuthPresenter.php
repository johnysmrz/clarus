<?php

namespace cms;

class AuthPresenter extends \clarus\presenter\Presenter {

    protected function _initialize() {
        \clarus\View::getInstance()->setLayoutTpl(PATH_TPL . '/backend/@loginLayout.php');
    }

    protected function _defaultAction() {
        $form = $this->createForm();
        $this->view->bind('form', $form);
        if ($form->processForm()) {
            $values = & $form->getValues();
            \clarus\i18n\Locale::getInstance()->setLocale($values['lang']);
            $autentificator = new BackendAutentificator($values['username'], $values['password']);
            $user = \clarus\security\autentification\User::autentificate($autentificator);
            if (isset($_GET['requested'])) {
                \clarus\Application::redir(base64_decode($_GET['requested']));
            } else {
                \clarus\Application::redir('/admin/default');
            }
        }
    }

    protected function _loginAction() {
        $this->_defaultAction();
    }

    protected function _logoutAction() {
        \clarus\security\autentification\User::logout();
        \clarus\Application::redir('/admin/auth/login');
    }

    protected function createForm() {
        $form = new \clarus\form\Form('login', 'post');
        $form->addItem(new \clarus\form\Text('username', array(\clarus\form\Item::LABEL => _('username'))));
        $form->addItem(new \clarus\form\Password('password', array(\clarus\form\Item::LABEL => _('password'))));
        $form->addItem(new \clarus\form\Select('lang',
                array(
                    \clarus\form\Item::SELECT_OPTIONS => array(
                        'cs_CZ.utf8' => 'česky ('._('cesky').')',
                        'en_US.utf8' => 'english ('._('anglicky').')'
                    ),
                    \clarus\form\Item::DEFAULT_VALUE => \clarus\i18n\Locale::getInstance()->getLocale()
                )
        ));
        $form->addItem(new \clarus\form\Submit('submit', array(\clarus\form\Item::DEFAULT_VALUE => _('login'))));
        return $form;
    }

    protected function _deInitialize() {

    }

}