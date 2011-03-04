<?php

class ajax_Form {
	
	public static function Dropdown() {
		$searchStr = data_Check::flatText($_POST['text']);
		$arr[] = 'ahoj';
		$arr[] = 'aloha';
		$arr[] = 'aleluja';
		$arr[] = 'auto';
		$arr[] = 'bravo';
		$arr[] = 'brouk';
		$arr[] = 'brno';
		$arr[] = 'barandov';
		$arr[] = 'charlie';
		$arr[] = 'cvrcek';
		$rtn = '';
		foreach ($arr as $value) {
			if (strstr($value,$searchStr) !== false) {
				$rtn .= '<line>'.$value.'</line>';
			}
		}
		return $rtn;
	}
	
}


?>