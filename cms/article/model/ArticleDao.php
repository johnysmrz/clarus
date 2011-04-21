<?php

namespace cms;

class ArticleDao extends \clarus\clo\Dao {

    protected function all() {
        //factory some entities
        $conn = \clarus\Application::getConnection();
        $query = $conn->query('SELECT * FROM t_article OFFSET ? LIMIT ?', $this->params->offset, $this->params->limit);
        $data = $query->execute();
        for($i = 1; $i < 5; $i++) {
            $data = array('id'=>$i,'name'=>'nejm','perex'=>'perex');
            $e = \clarus\clo\Mapper::getMapper('\\cms\\ArticleMapper')->createEntity($data);
            $this->addCollectionItem($e);
        }
    }

}