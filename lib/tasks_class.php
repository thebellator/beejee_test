<?php
require_once "global_class.php";

class Tasks extends GlobalClass {
    public function __construct($db) {
        parent::__construct("tasks", $db);
    }

    public function addTask($data){
        return $this->add($data);
    }

    public function completed($id){
        return $this->edit($id, array('finished' => 1));
    }

    public function editTask($id, $upd_fields)
    {
        return $this->edit($id, $upd_fields);
    }
}