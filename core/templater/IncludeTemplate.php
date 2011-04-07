<?php

namespace clarus\templater;

class IncludeTemplate implements IPlugin {

    public function getAbilities() {
        return array('include');
    }

    public function resolve($type, $args) {
        return '<?php include(\clarus\templater\Templater::get('.$args.')) ?>';
    }

}