<?php

namespace cms;

/**
 * Basic backend presenter
 * @author johny
 * @package cms
 */
abstract class BackendPresenter extends \clarus\presenter\Presenter implements \clarus\ioc\IInjectable {

    protected function _initialize() {
        \clarus\View::getInstance()->setLayoutTpl(\PATH_TPL.'/backend/@layout.php');
    }

}
?>
