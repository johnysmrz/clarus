<?php

namespace clarus\cache;

class ApcProvider extends Provider {

    public function __construct() {
        if(!\extension_loaded('apc')) {
            throw new \clarus\Exception('Extension APC not loaded, can\'t continue', 1);
        }
    }


    protected function loadContainer($namespace) {
        $var = \apc_fetch('cache_'.$namespace, $success);
        if($success) {
            return $var;
        } else {
            return NULL;
        }
    }

    protected function saveContainer($namespace, $serialized) {
        \apc_store('cache_'.$namespace, $serialized);
    }

}