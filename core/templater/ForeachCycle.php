<?php

namespace clarus\templater;

class ForeachCycle implements IPlugin {

    protected static $instance = NULL;

    public function resolve($name, $args) {
        if($name === '/foreach') {
            return '<?php endforeach; ?>';
        }

        $from = NULL;
        $key = NULL;
        $value = NULL;

        foreach(\explode(' ', $args) as $param) {
            if(\preg_match('~^([a-z0-9_]+)\=\$([a-z0-9_]+)$~', $param, $paramMatches)) {
                switch ($paramMatches[1]) {
                    case 'from':
                        $from = $paramMatches[2];
                        break;
                    case 'key':
                        $key = $paramMatches[2];
                        break;
                    case 'value':
                        $value = $paramMatches[2];
                        break;
                    default:
                        throw new ParserException('Unexcepted param ['.$param.']', 1);
                }
            } else {
                throw new ParserException('Unexcepted param ['.$param.']', 1);
            }
        }

        return '<?php foreach($this->getTplVar(\''.$from.'\') as '.(isset($key) ? '$'.$key.'=>' : NULL).' $'.$value.'): ?>';
    }

    public function getAbilities() {
        return array('foreach', '/foreach');
    }

}
