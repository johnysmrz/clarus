<?php

namespace clarus\templater;

class ForeachCycle extends \clarus\scl\SingletonObject {

    protected static $instance = NULL;

    const T_FOREACH = 'foreach';
    const T_FOREACH_FROM = 'from';
    const T_FOREACH_KEY = 'key';
    const T_FOREACH_VALUE = 'value';

    public static function getInstance() {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function resolveString($matches) {
        if($matches[0] === '/foreach') {
            return '<?php endforeach; ?>';
        }

        $from = NULL;
        $key = NULL;
        $value = NULL;

        foreach(\explode(' ', $matches['params']) as $param) {
            if(\preg_match('~^([a-z0-9_]+)\=\$([a-z0-9_]+)$~', $param, $paramMatches)) {
                switch ($paramMatches[1]) {
                    case self::T_FOREACH_FROM:
                        $from = $paramMatches[2];
                        break;
                    case self::T_FOREACH_KEY:
                        $key = $paramMatches[2];
                        break;
                    case self::T_FOREACH_VALUE:
                        $value = $paramMatches[2];
                        break;
                    default:
                        throw new Exception('Unexcepted param ['.$param.']', 1);
                }
            } else {
                throw new Exception('Unexcepted param ['.$param.']', 1);
            }
        }

        return '<?php foreach($this->getTplVar(\''.$from.'\') as '.(isset($key) ? '$'.$key.'=>' : NULL).' $'.$value.'): ?>';
    }

}
