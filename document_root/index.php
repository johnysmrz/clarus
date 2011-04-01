<?php

namespace clarus;

include_once('../init.php');

try {
    new loader\App();

    Application::setConnection(new dbal\PgSql('test', 'localhost', 'postgres', 'pass'));

    Application::addRouote(new router\Backend('admin'));

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