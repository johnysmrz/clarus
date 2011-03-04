<?php

class Application {

    protected static $router = array();
    protected static $defaultPresenter = NULL;
    protected static $defaultAction = NULL;
    protected static $defaultParam = NULL;
    protected static $presenter = NULL;
    protected static $action = NULL;
    protected static $param = NULL;

    public static function run() {
        if (($router = self::getRouter()) instanceof router_Router) {
            $presenter = self::$presenter = $router->getPresenter();
            $action = self::$action = $router->getAction();
            $param = self::$param = $router->getParam();
        } else {
            $presenter = self::$presenter = self::$defaultPresenter;
            $action = self::$action = self::$defaultAction;
            $param = self::$param = self::$defaultParam;
        }

        $presenter = 'presenter_'.$presenter;
        $action = $action === NULL ? $action = 'default' : $action;

        //echo '<pre>' . print_r(array('presenter'=>$presenter, 'action'=>$action, 'param'=>$param), true) . '</pre>';

        $p = new $presenter($action, $param);
    }

    public static function addRouote(router_Router $router) {
        self::$router[] = $router;
    }

    public static function defaultPresenter($presenter, $action = NULL, $param = NULL) {
        self::$defaultPresenter = $presenter;
        self::$defaultAction = $action;
        self::$defaultParam = $param;
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
        View::getInstance()->setContentTpl(PATH_TPL.'/'.View::createTemplateName(self::$presenter, self::$action).'.php');
        View::getInstance()->display();
    }

    public static function redir($url) {
        header('Location: '.$url);
        exit();
    }

}

?>