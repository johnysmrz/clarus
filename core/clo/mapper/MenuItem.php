<?php

class Clo_Mapper_MenuItem extends Clo_Mapper {

    protected function setUp() {
        // setup producetd entity
        $this->setEntity('Clo_Entity_MenuItem');
        // setup primary key
        $this->setPrimary('id', 'id');
        // setup attributes
        $this->setAttribute('content_template', 'content_template');
        $this->setAttribute('id_mapa', 'id_mapa');
        $this->setAttribute('target', 'target');
        $this->setAttribute('title', 'title');
        $this->setAttribute('link_text', 'link_text');
        $this->setAttribute('index_name', 'index_name');
        $this->setAttribute('join_url', 'join_url');
        // setup connection to other entities
        $this->setConnectionToMany('parent', 'Clo_Dao_MenuItem', 'getById', 'parent=id');
        $this->setConnectionToOne('url', 'Clo_Dao_Url', 'get', 'url=index_name');
    }

}

?>
