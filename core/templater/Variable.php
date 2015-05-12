<?php

namespace clarus\templater;

class Variable implements IPlugin {

    public function __construct() {

    }

    public function getAbilities() {
        return array('$');
    }

    public function resolve($type, $args) {
        if(($gtPos = \strpos($args, '>')) !== FALSE) {
            $class = \substr($args, 0, $gtPos);
            $method = \substr($args, $gtPos+1);
            return '<?php echo $'.$class.'->'.$method.' ?>';
        } else {
            return '<?php echo $this->getTplVar(\''.$args.'\') ?>';
        }
    }

}