<?php

namespace cms;

class ArticlePresenter extends \clarus\presenter\Backend {

    protected function _defaultAction() {
        $this->_overviewAction();
    }

    protected function _overviewAction() {
        $articles = \clarus\clo\Clo::get('\\cms\\ArticleDao', 'all', array('limit'=>10,'offset'=>0));
        $articles->forceLoad();
        \clarus\View::getInstance()->bind('articles', $articles);
    }

    protected function _editAction($id) {

    }
}