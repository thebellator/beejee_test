<?php
require_once "global_class.php";

class User extends GlobalClass {
	public function __construct($db) {
		parent::__construct("users", $db);
	}

	public function Auth($login, $password){
        $id = $this->getField("id", "login", $login);
        if (!$id) false;
        $user = $this->get($id);
        if (!$user) return false;
        return ($user["password"] === $password)? $user: false;
    }
}

?>