<?php

namespace cms;

/**
 * Basic presenter for all frontend presenters
 * @author Jan Smrz
 * @package cms
 */
abstract class Presenter extends \clarus\presenter\Presenter implements \clarus\ioc\IInjectable {

    /**
     * @IocInject('cacheprovider')
     */
    protected $cache = NULL;

    protected function _initialize() {
        \clarus\ioc\Container::inject($this);
        \clarus\View::getInstance()->setLayoutTpl(\PATH_TPL.'/@layout.php');
    }

}