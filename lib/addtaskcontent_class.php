<?php
require_once "modules_class.php";

class AddTaskContent extends Modules {

    public function __construct($db) {
        parent::__construct($db);
    }

    protected function getTittle()
    {
        return 'Task';
    }

    protected function getMiddle()
    {
        if (!isset($_SESSION['add_task_error'])){
            $sr['class'] = '';
            $sr['add_alert_txt'] = '';
        }
        elseif ($_SESSION['add_task_error']){
            $sr['class'] = 'alert alert-warning';
            $sr['add_alert_txt'] = 'Задача не добавлено!';
        }
        else{
            $sr['class'] = 'alert alert-success';
            $sr['add_alert_txt'] = 'Задача успешно добавлено!';
        }
        $_SESSION['add_task_error'] = null;
        return $this->getReplaceTemplate($sr, "add_task");
    }



}