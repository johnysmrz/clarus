<?php

namespace clarus\cache;

class FileProvider extends Provider {

    protected $basePath = NULL;

    public function __construct($savePath = NULL) {
        $this->basePath = \PATH_CACHE.'/'.($savePath === NULL ? 'cache' : $savePath);
        if(!\file_exists($this->basePath)) {
            \mkdir($this->basePath, 0777, \TRUE);
        }
        parent::__construct();
    }

    protected function loadContainer($namespace) {
        if(\file_exists($this->basePath.'/'.$namespace)) {
            return \file_get_contents($this->basePath.'/'.$namespace);
        } else {
            return NULL;
        }
    }

    protected function saveContainer($namespace, $serialized) {
        \file_put_contents($this->basePath.'/'.$namespace, $serialized);
    }


}