<?php

class ajax_Admin {
	
	public static function Login() {
		try {
			$username = control_data_Check::flatText($_POST['username']);
			$password = control_data_Check::flatText($_POST['password']);
			control_auth_User::authBack($username,$password);
			return '<login>ok</login>';
		} catch (control_auth_Exception $ae) {
			return '<error>'.$ae->getMessage().'</error>';
		}
	}
	
	public static function getBranch() {
		$id = control_data_Check::int($_POST['nid']);
		$b = new admin_nodeTree_Branch($id);
		ob_start();
		$b->show();
		return '<htmlContent>'.ob_get_clean().'</htmlContent>';
	}
	
	public static function test() {
		sleep(2);
		return '<data>some data</data>';
	}
	
}

?>