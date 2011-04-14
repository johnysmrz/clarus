<?php

namespace clarus\scl;

class FileNotFoundException extends \clarus\Exception {

    public function  __construct($filepath) {
        parent::__construct('File ['.$filepath.'] not found!', 1);
    }

}