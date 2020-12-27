<?php
require_once "modules_class.php";

class AuthContent extends Modules {

    public function __construct($db) {
        parent::__construct($db);
        if ($this->user_info) $this->redirect($this->config->address);
    }

    protected function getTittle()
    {
        return 'Auth';
    }

    protected function getMiddle()
    {
        $sr["error_message"] = ($_SESSION["error_message"])? '<div class="alert alert-danger" role="alert">Не праильный логин/пароль!</div>' : '';
        $_SESSION["error_message"] = false;
        return $this->getReplaceTemplate($sr, "autoriz");
    }



}