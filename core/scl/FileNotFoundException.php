<?php

class scl_FileNotFoundException extends BasicException {

    public function  __construct($filepath) {
        parent::__construct('File ['.$filepath.']', 1);
    }

}