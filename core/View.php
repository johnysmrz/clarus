<?php

namespace clarus;

class View implements IDisplayable {

    private static $instance = null;
    protected $variables = array();
    protected $layoutTpl = null;
    protected $contentTpl = null;
    protected $templater = null;

    final private function __construct() {
        
    }

    /**
     * @return View 
     */
    public static function getInstance() {
        if (self::$instance instanceof View)
            return self::$instance;
        else
            return self::$instance = new View();
    }

    /**
     * Bidn variable into view
     * @param string $name
     * @param mixed $value
     * @return View
     */
    public function bind($name, $value) {
        $this->variables[$name] = $value;
        return $this;
    }

    public function setLayoutTpl($tpl) {
        $this->layoutTpl = $tpl;
        return $this;
    }

    public function setContentTpl($tpl) {
        $this->contentTpl = $tpl;
        return $this;
    }

    public function display($template = NULL) {
        include_once(templater\Templater::get($this->layoutTpl));
        return $this;
    }

    public function getTplVar($name) {
        if (isset($this->variables[$name])) {
            return $this->variables[$name];
        } else {
            return '';
        }
    }

    public static function createTemplateName($presenter,$action = NULL,$param = NULL) {
        if($action === NULL) $action = 'default';
        $pathParts = explode('\\', strtolower($presenter));
        $pathParts[] = $action;
        return implode('/', $pathParts);
    }
}