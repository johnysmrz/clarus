<?php

namespace clarus\scl;

class FileNotFoundException extends Exception {

    public function  __construct($filepath) {
        parent::__construct('File ['.$filepath.'] not found!', 1);
    }

}