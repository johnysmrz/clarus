<?php

/**
 * Sablonovac, popis chybi :)
 * @author Jan Smrz
 * @package core
 */
class templater_Templater extends object_Singleton {

    protected static $instance = NULL;

    /**
     * get instance
     * @return templater_Templater
     */
    protected static function getInstance() {
        if(!(self::$instance instanceof self)) {
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
        if (!file_exists($originalFileName)) throw new scl_FileNotFoundException($originalFileName);
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
        $cacheFolder = PATH_CACHE.'/tpl/'.i18n_Locale::getInstance()->getLocale();
        if(!file_exists($cacheFolder)) {
            mkdir($cacheFolder, 0777, TRUE);
        }
        return $cacheFolder . '/' . md5($originalFileName);
    }

    /**
     * Zkompiluje a ulozi sablonu do cache
     * @param <type> $originalFileName
     */
    protected function compileTemplate($originalFileName) {
        if (!file_exists($originalFileName)) throw new scl_FileNotFoundException($originalFileName);
        $templateContent = file_get_contents($originalFileName);
        $compiledFileName = self::getCompiledFileName($originalFileName);
        $templateContent = $this->parser($templateContent);
        touch($originalFileName);
        file_put_contents($compiledFileName, $templateContent);
    }

    protected function parser($content) {
        return preg_replace_callback('~\{([a-zA-Z0-9_ $]+)\}~', array($this, 'resolveToken'), $content);
    }

    protected function resolveToken($token) {
        $token = $token[1];
        $newToken = $token;
        if (preg_match('~^\$([a-zA-Z0-9_-]+)$~', $token, $matches)) {
            $newToken = '<?php echo $this->getTplVar(\'' . $matches[1] . '\') ?>';
        } else if ($token == 'content') {
            $newToken = '<?php include(templater_Templater::get($this->contentTpl)) ?>';
        }
        return $newToken;
    }

}