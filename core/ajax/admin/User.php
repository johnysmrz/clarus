<?php

class ajax_admin_User {
	
	public static function loadForm() {
		$_GET['action'] = 'edit';
		$usermodule = new admin_module_Users();
		$usermodule->add();
		ob_start();
		$usermodule->show();
		return '<editform>'.ob_get_clean().'</editform>';
	}
	
}

?>