<?php

namespace clarus;

include_once('../init.php');
include_once('../core/_loader.php');
include_once('../cms/_loader.php');

try {

    Application::addRouote(new router\Backend('admin'));
    Application::addRouote(new router\HomepageRouter('\\cms\\DefaultPresenter'));

    Application::run();

    Application::display();
} catch (security\autentification\Exception $sae) {
    if (isset($_GET['requested'])) {
        Application::redir('/admin/auth/login?requested=' . $_GET['requested']);
    } else {
        Application::redir('/admin/auth/login?requested=' . base64_encode($_SERVER['REQUEST_URI']));
    }
} catch (Exception $e) {
    echo '<pre>' . print_r($e, true) . '</pre>';
}