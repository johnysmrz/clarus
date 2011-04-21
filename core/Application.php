<?php

namespace clarus;

/**
 * Basic class for running application, should be called only staticaly
 */
class Application {
    const DEFAULT_CONNECTION = '__default__connection__';
    const HTTP_RESPONSE_OK = 'HTTP/1.1 200 OK';
    const HTTP_RESPONSE_NOT_FOUND = 'HTTP/1.0 404 Not Found';

    protected static $router = array();
    protected static $presenter = NULL;
    protected static $action = NULL;
    protected static $param = NULL;
    protected static $locale = NULL;
    protected static $connectors = array();
    protected static $httpResponseCode = NULL;
    /**
     * @var IErrorPresenter
     */
    protected static $errorPresenter = NULL;

    public static function run() {
        self::setupLocale();

        if (defined('GETTEXT_USE') && GETTEXT_USE === TRUE) {
            self::initGettext();
        }

        if (($router = self::getRouter()) instanceof router\Router) {
            $presenter = self::$presenter = $router->getPresenter();
            $action = self::$action = $router->getAction();
            $param = self::$param = $router->getParam();
        } else if (self::$errorPresenter instanceof presenter\IErrorPresenter) {
            $presenter = self::$errorPresenter;
            $action = '404';
        } else {
            $presenter = NULL;
        }

        if (class_exists($presenter)) {
            $action = $action === NULL ? $action = 'default' : $action;
            $p = new $presenter($action, $param);
            self::$httpResponseCode = self::HTTP_RESPONSE_OK;
        } else {
            \trigger_error('Presenter class ['.$presenter.' not found', \E_USER_WARNING);
            self::$httpResponseCode = self::HTTP_RESPONSE_NOT_FOUND;
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
        if (\defined('DEBUG') && DEBUG) {
            foreach (self::$router as $router) {
                \FB::info(($router->match() ? 'MATCH' : 'NOT MATCH').' router ' . \get_class($router));
            }
        }
        foreach (self::$router as $router) {
            if ($router->match())
                return $router;
        }
        return FALSE;
    }

    public static function display() {
        \header('X-Powered-By: PHP/' . phpversion() . '; Clarus-Framework/' . CLARUS_VERSION);
        \header(self::$httpResponseCode);
        if (self::$httpResponseCode == self::HTTP_RESPONSE_OK) {
            \clarus\View::getInstance()->setContentTpl(PATH_TPL . '/' . View::createTemplateName(self::$presenter, self::$action) . '.php');
            \clarus\View::getInstance()->display();
        } else {
            // default error page
            self::flushDefaultErrorPage();
            exit ();
        }
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
            self::$connectors[self::DEFAULT_CONNECTION] = $connector;
        }
    }

    /**
     * Vraci vytvorene pojmenovane spojeni
     * @param string $name
     * @return IConnectable
     */
    public static function getConnection($name = NULL) {
        if ($name === NULL) {
            return self::$connectors[self::DEFAULT_CONNECTION];
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

    public static function flushDefaultErrorPage() {
?>
        <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
        <html><head>
                <title><?php echo self::$httpResponseCode ?></title>
            </head><body>
                <h1><?php echo self::$httpResponseCode ?></h1>
                <p><?php echo _('The requested URL was not found on this server.') ?></p>
                <hr>
<?php echo $_SERVER['SERVER_SIGNATURE'] ?>
                <address>Clarus Framework Application <?php echo CLARUS_VERSION ?></address>
    </body></html>
<?php
    }

}