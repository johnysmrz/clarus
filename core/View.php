<?php

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

    public function bind($name, $value) {
        if(is_scalar($value) || $value instanceof IDisplayable) {
            $this->variables[$name] = $value;
        } else {
            throw new InvalidArgumentException('Value must be scalar or instance of IDisplayable', 1);
        }
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
        include_once(templater_Templater::get($this->layoutTpl));
        return $this;
    }

    public function getTplVar($name) {
        if (isset($this->variables[$name])) {
            return $this->variables[$name];
        } else {
            throw new InvalidArgumentException('Unknown var ['.$name.']', 1);
        }
    }

    public static function createTemplateName($presenter,$action = NULL,$param = NULL) {
        if($action === NULL) $action = 'default';
        $pathParts = explode('_', strtolower($presenter));
        $pathParts[] = $action;
        return implode('/', $pathParts);
    }
}