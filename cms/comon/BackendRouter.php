<?php

namespace cms;

/**
 * Backend router, simply translate adress after $base to router, action and id
 * ex.: /admin/router/action/id
 * @author Jan Smrz
 * @package cms
 */
class BackendRouter extends \clarus\router\Router {

    /**
     * @var string
     */
    protected $base = NULL;

    /**
     * Constructor
     * @param string $base
     * @param array $flags
     */
    public function __construct($base = 'admin', $flags = array()) {
        $this->base = $base;
        parent::__construct($flags);
    }

    /**
     * @return bool
     */
    public function match() {
        if (isset($_SERVER['REDIRECT_URL'])) {
            $parts = explode('/', trim($_SERVER['REDIRECT_URL'], '/'));
            if (isset($parts[0]) && $parts[0] === $this->base && isset($parts[1]) && is_string($parts[1])) {
                $this->setPresenter('\\cms\\'.ucfirst($parts[1]).'BackendPresenter');
                if (isset($parts[2])) {
                    $this->setAction($parts[2]);
                }
                if (isset($parts[3])) {
                    $this->setParam($parts[3]);
                }
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }
}