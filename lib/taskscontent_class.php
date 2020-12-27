<?php
require_once "modules_class.php";

class TaskContent extends Modules {

    public function __construct($db) {
        parent::__construct($db);
    }

    protected function getTittle()
    {
        return 'Task';
    }

    protected function getMiddle()
    {
        $task_id = $this->data['id'];
        $task = $this->tasks->get($task_id);
        $sr['user_name'] = $task['user_name'];
        $sr['user_email'] = $task['user_email'];
        $sr['task_text'] = $task['task_text'];
        $sr['task_id'] = $task['id'];
        if ((int)$task['finished'] === 1){
            $sr['finished_alert'] = "Задача выполенено!";
            $sr['class'] = 'alert alert-success';
        }
        else{
            $sr['finished_alert'] = "Задача не выполенено!";
            $sr['class'] = 'alert alert-warning';
        }
        return ($this->getUser())?  $this->getReplaceTemplate($sr, "edit_task") : $this->getReplaceTemplate($sr, "task_page");
    }



}