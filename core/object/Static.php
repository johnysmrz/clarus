<?php

class object_Static {

    final private function  __construct() {
        throw new LogicException('Static object canot be instantied', 1);
    }

}