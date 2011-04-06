<?php

namespace clarus\templater;

/**
 * Sablonovac, popis chybi :)
 * @todo upravit na pluginy
 * @author Jan Smrz
 * @package clarus
 * @subpackage templater
 */
class Templater extends \clarus\scl\SingletonObject {

    protected static $instance = NULL;

    /**
     * get instance
     * @return templater_Templater
     */
    protected static function getInstance() {
        if (!(self::$instance instanceof self)) {
            return self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * konstruktor je tu pouze z duvodu aby nesel zavolat zvenku
     */
    protected function __construct() {

    }

    /**
     * Vrati cestu ke zkompilovane sablone v pripade potreby provede rekompilaci
     * @param string $originalFileName
     * @return string
     */
    public static function get($originalFileName) {
        if (!file_exists($originalFileName))
            throw new \clarus\scl\FileNotFoundException($originalFileName);
        $originalFileName = realpath($originalFileName);

        $compiledFileName = self::getCompiledFileName($originalFileName);

        if (file_exists($compiledFileName)) {
            $originalFileMTime = filemtime($originalFileName);
            $compiledFileMTime = filemtime($compiledFileName);
            if ($originalFileMTime !== $compiledFileMTime) {
                self::getInstance()->compileTemplate($originalFileName);
            }
        } else {
            self::getInstance()->compileTemplate($originalFileName);
        }

        return $compiledFileName;
    }

    /**
     * Vraci cestu k cache zkompilovane sablony
     * @param string $originalFileName
     * @return string
     */
    protected static function getCompiledFileName($originalFileName) {
        $cacheFolder = PATH_CACHE . '/tpl/' . \clarus\i18n\Locale::getInstance()->getLocale();
        if (!file_exists($cacheFolder)) {
            mkdir($cacheFolder, 0777, TRUE);
        }
        return $cacheFolder . '/' . md5($originalFileName);
    }

    /**
     * Zkompiluje a ulozi sablonu do cache
     * @param <type> $originalFileName
     */
    protected function compileTemplate($originalFileName) {
        if (!file_exists($originalFileName))
            throw new \clarus\scl\FileNotFoundException($originalFileName);
        $templateContent = file_get_contents($originalFileName);
        $compiledFileName = self::getCompiledFileName($originalFileName);
        $templateContent = $this->parser($templateContent);
        //touch($originalFileName);
        file_put_contents($compiledFileName, $templateContent);
    }

    protected function parser($content) {
        return preg_replace_callback('~\{([a-zA-Z0-9\ \_\-\,\$\=\/\>]+)\}~', array($this, 'resolveToken'), $content);
    }

    protected function resolveToken($token) {
        $token = $token[1];
        $newToken = $token;
        preg_match('~^(?<decisive>[a-zA-Z]+|[\/\$_])(?<first>[a-zA-Z\>]+| |)(?<params>.*)~', $token, $matches);
        if ('$' == $matches['decisive']) {
            $newToken = '<?php echo $this->getTplVar(\'' . $matches['first'] . '\') ?>';
        } else if ('content' == $matches['decisive']) {
            $newToken = '<?php include(\clarus\templater\Templater::get($this->contentTpl)) ?>';
        } else if('_' == $matches['decisive'] && ' ' == $matches['first']) {
            $newToken = Gettext::getInstance()->resolveString($matches['params']);
        } else if('foreach' == $matches['decisive'] || ('foreach' == $matches['first'] && '/' == $matches['decisive']) ) {
            $newToken = ForeachCycle::getInstance()->resolveString($matches);
        } else {
            return $token;
        }
        return $newToken;
    }

}