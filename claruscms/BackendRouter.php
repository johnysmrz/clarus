<?php

namespace claruscms;

class BackendRouter extends \clarus\router\Router {
	
	protected $adminUrl = NULL;

	public function __construct($adminUrl = 'admin') {
		$this->adminUrl = $adminUrl;
	}

	public function match() {
		if(isset($_SERVER['REDIRECT_URL'])) {
			$parts = explode('/', trim($_SERVER['REDIRECT_URL'], '/'));
			if(isset($parts[0]) && $parts[0] == $this->adminUrl) {
				if(isset($parts[1])) {
					$this->controller = sprintf('%s\\controller\\%s', __NAMESPACE__, ucfirst($parts[1]));
				};
				if(isset($parts[2])) {
					$this->method = sprintf('%sMethod', mb_strtolower($parts[2]));
				};
				return TRUE;
			}
		}
		return FALSE;
	}

}