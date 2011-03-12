<?php

include_once('../init.php');

try {
    //DB::connect('pgsql', 'localhost', 'test', 'postgres', 'pass');

    Application::addRouote(new router_Backend('admin'));
    //Application::addRouote(new router_DB());
    Application::defaultPresenter('Default');

    Application::run();

    Application::display();
} catch (security_autentification_Exception $sae) {
    if (isset($_GET['requested'])) {
        Application::redir('/admin/auth/login?requested=' . $_GET['requested']);
    } else {
        Application::redir('/admin/auth/login?requested=' . base64_encode($_SERVER['REQUEST_URI']));
    }
} catch (Exception $e) {
    Debugger::showException($e);
}