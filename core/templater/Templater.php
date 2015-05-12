<?php

namespace clarus\templater;

/**
 * Main templating class
 * @todo upravit na pluginy
 * @author Jan Smrz
 * @package clarus
 * @subpackage templater
 */
class Templater extends \clarus\scl\SingletonObject {

    protected static $instance = NULL;
    protected $plugins = array();

    /**
     * get instance
     * @return Templater
     */
    protected static function getInstance() {
        if (!(self::$instance instanceof self)) {
            return self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor defines basic (internal) plugins
     */
    protected function __construct() {
        //register internal plugins
        $this->registerPlugin(new ForeachCycle());
        $this->registerPlugin(new Variable());
        $this->registerPlugin(new IncludeTemplate());
        if (\defined('\GETTEXT_USE') && \GETTEXT_USE == TRUE) {
            $this->registerPlugin(new Gettext());
        }
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
        $cacheFilename = \substr($originalFileName, \strrpos($originalFileName, '/') + 1, 10) . \md5($originalFileName);
        $cacheFilename = \str_replace(array('.', '@'), '', $cacheFilename);
        $cacheFolder = PATH_CACHE . '/tpl/' . \clarus\i18n\Locale::getInstance()->getLocale();
        if (!file_exists($cacheFolder)) {
            mkdir($cacheFolder, 0777, TRUE);
        }
        return $cacheFolder . '/' . $cacheFilename;
    }

    /**
     * Zkompiluje a ulozi sablonu do cache
     * @param <type> $originalFileName
     */
    protected function compileTemplate($originalFileName) {
        if (!file_exists($originalFileName)) {
            throw new \clarus\scl\FileNotFoundException($originalFileName);
        }
        $templateContent = file_get_contents($originalFileName);
        $compiledFileName = self::getCompiledFileName($originalFileName);
        $templateContent = $this->parser($templateContent);
        //touch($originalFileName);
        file_put_contents($compiledFileName, $templateContent);
    }

    protected function parser($content) {
        return preg_replace_callback('~\{(?<first>[a-zA-Z0-9_\/]+|\$) ?(?<args>[^}^{\r\n]+)?\}~', array($this, 'resolveToken'), $content);
    }

    protected function resolveToken($token) {
        if (isset($this->plugins[$token['first']])) {
            return $this->plugins[$token['first']]->resolve($token['first'], isset($token['args'])?$token['args']:NULL);
        }
        return $token[0];
    }

    public function registerPlugin(IPlugin $plugin) {
        if (!\is_array($plugin->getAbilities())) {
            throw new \clarus\scl\InvalidReturnException(\get_class($plugin) . '::getAbilities() should return array', 1);
        }
        foreach ($plugin->getAbilities() as $ability) {
            $this->plugins[$ability] = $plugin;
        }
    }

}