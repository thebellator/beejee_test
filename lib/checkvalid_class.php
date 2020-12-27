<?php
require_once "config_class.php";

class CheckValid {
	
	private $config;
	
	public function __construct() {
		$this->config = new Config();
	}
	
	public function validID($id) {
		if (!$this->isIntNumber($id)) return false;
		if ($id <= 0) return false;
		return true;
	}
	
	public function validInt($int){
		if (!$this->isIntNumber($int)) return false;
		return true;
	}

	public function validEmail($email){
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
	
	public function validName($name){
		if(!preg_match("/^[a-zA-Zа-яА-Я]+$/ui", $name)) return false;
		return true;
	}

	public function validHash($hash) {
		if (!$this->validString($hash, 32, 32)) return false;
		if (!$this->isOnlyLettersAndDigits($hash)) return false;
		return true;
	}

	private function isIntNumber($number) {
		if (!is_int($number) && !is_string($number)) return false;
		if (!preg_match("/^-?(([1-9][0-9]*|0))$/", $number)) return false;
		return true;
	}
	
	private function isNoNegativeInteger($number){
		if (!$this->isIntNumber($number)) return false;
		if ($number < 0) return false;
		return true;
	}
	
	private function isOnlyLettersAndDigits($string) {
		if (!is_int($string) && (!is_string($string))) return false;
		if (!preg_match("/[a-zа-я0-9]*/i", $string)) return false;
		return true;
	}
	
	private function validString($string, $min_length, $max_length) {
		if (!is_string($string)) return false;
		if (strlen($string) < $min_length) return false;
		if (strlen($string) > $max_length) return false;
		return true;
	}
	
	private function isContainQuotes($string) {
		$array = array("\"", "'", "`", "&quot;", "&apos;");
		foreach ($array as $key => $value) {
			if (strpos($string, $value) !== false) return true;
		}
		return false;
	}
}

?>