<?php

namespace clarus;

/**
 * Basic class for running application, should be called only staticaly
 */
class Application {
    const defaultConnection = '__default__connection__';

    protected static $router = array();
    
    protected static $presenter = NULL;
    protected static $action = NULL;
    protected static $param = NULL;

    protected static $locale = NULL;
    protected static $connectors = array();

    public static function run() {
        self::setupLocale();

        if (defined('GETTEXT_USE') && GETTEXT_USE === TRUE) {
            self::initGettext();
        }

        if (($router = self::getRouter()) instanceof router\Router) {
            $presenter = self::$presenter = $router->getPresenter();
            $action = self::$action = $router->getAction();
            $param = self::$param = $router->getParam();
        }

        $presenter = 'presenter_' . $presenter;
        if(class_exists($presenter)) {
            $action = $action === NULL ? $action = 'default' : $action;
            $p = new $presenter($action, $param);
        }
                
    }

    public static function addRouote(router\Router $router) {
        self::$router[] = $router;
    }

    /**
     * Vrati prvni router ktery odpovida URL adrese
     * @return router_Router
     */
    private static function getRouter() {
        foreach (self::$router as $router) {
            if ($router->match())
                return $router;
        }
        return FALSE;
    }

    public static function display() {
        View::getInstance()->setContentTpl(PATH_TPL . '/' . View::createTemplateName(self::$presenter, self::$action) . '.php');
        View::getInstance()->display();
    }

    /**
     * Pomocna fce
     * Provede presmerovani pomoci hlavicky
     * @param string $url
     */
    public static function redir($url) {
        header('Location: ' . $url);
        exit();
    }

    /**
     * Nastavi prostredi pro gettext
     */
    protected static function initGettext() {
        bindtextdomain("messages", PATH . '/locale');
        textdomain("messages");
    }

    protected static function setupLocale() {
        $locale = i18n\Locale::getInstance();
        if (isset($_GET['setlocale'])) {
            $locale->setLocale($_GET['setlocale']);
        }
    }

    /**
     * Prida do kontextu aplikace nove spojeni
     * @param IConnectable $connector instance connectoru spojeni
     * @param string $name pojmenovani spojeni pro budouci pouziti
     * @param bool $default
     */
    public static function setConnection(IConnectable $connector, $name = NULL) {
        if ($name !== NULL) {
            self::$connectors[$name] = $connector;
        } else {
            self::$connectors[self::defaultConnection] = $connector;
        }
    }

    /**
     * Vraci vytvorene pojmenovane spojeni
     * @param string $name
     * @return IConnectable
     */
    public static function getConnection($name = NULL) {
        if ($name === NULL) {
            return self::$connectors[self::defaultConnection];
        } else {
            if (isset(self::$connectors[$name])) {
                if (!self::$connectors[$name]->checkConnection()) {
                    self::$connectors[$name]->connect();
                }
                return self::$connectors[$name];
            } else {
                throw new InvalidArgumentException('Connection ' . $name . ' not exists', 1);
            }
        }
    }

    //protected static function generateError

}