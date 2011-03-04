<?php

include_once('../init.php');

try {
    DB::connect('pgsql','localhost','test','postgres','pass');

    Application::addRouote(new router_Backend('admin'));
    Application::addRouote(new router_DB());
    Application::defaultPresenter('Default');

    Application::run();

    Application::display();
} catch (security_autentification_Exception $sae) {
    Application::redir('/admin/login');
} catch (Exception $e) {
    Debugger::showException($e);
}