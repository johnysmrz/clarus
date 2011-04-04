<?php

/**
 * @package main
 * @SimpleAnnotation
 * @BoolAnnotation(true)
 * @NumberAnnotation(-3.141592)
 * @StringAnnotation('Hello World!')
 * @SimpleArrayAnnotation({1, 2, 3, "hello", TRUE, false, NULL, 1.22})
 * @MultiValuedAnnotation(key = 'value', anotherKey = false, andMore = 1234) 
 */
class presenter_Default extends presenter_Presenter {
    protected function _deInitialize() {

    }

    protected function _defaultAction() {

    }

    protected function _initialize() {
        $this->view->setLayoutTpl(PATH_TPL.'/@layout.php');
        
    }

}