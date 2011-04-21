<?php

namespace cms;

class ArticleMapper extends \clarus\clo\Mapper {

    protected function setUp() {
        $this->setPrimary('id','id');
        $this->setAttribute('name');
        $this->setAttribute('perex');
        $this->setEntity('\\cms\\Article');
    }

}