<?php

namespace clarus\templater;

class Gettext extends \clarus\scl\SingletonObject {

    protected static $instance = NULL;
    protected $gettextDictionaryHelper;
    protected $inDictionary = array();

    public static function getInstance() {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function __construct() {
        $this->gettextDictionaryHelper = PATH_CACHE . '/tpl/gettextDictionaryHelper.php';
        if (!file_exists($this->gettextDictionaryHelper)) {
            file_put_contents($this->gettextDictionaryHelper, '<?php');
        }
        $this->parseDictionary();
    }

    protected function parseDictionary() {
        $dictionary = file($this->gettextDictionaryHelper);
        foreach ($dictionary as $value) {
            preg_match('~^_\(\'(?<word>.+)\'\)\;~', $value, $matches);
            if (isset($matches['word'])) {
                $this->inDictionary[] = $matches['word'];
            }
        }
    }

    public function resolveString($string) {
        if (!in_array($string, $this->inDictionary)) {
            $this->inDictionary[] = $string;
        }
        return _($string);
    }

    public function __destruct() {
        $dictionaryContent = "<?php \n";
        foreach ($this->inDictionary as $word) {
            $dictionaryContent .= "_('$word');\n";
        }
        $dictionaryContent .= '?>';
        file_put_contents($this->gettextDictionaryHelper, $dictionaryContent);
    }

}