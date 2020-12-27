<?php
require_once "config_class.php";
require_once "user_class.php";
require_once "tasks_class.php";

class Manage {
	private $config;
	private $user;
	private $tasks;
	private $data;

	public function __construct($db) {
		session_start();
		$this->config = new Config();
		$this->user = new User($db);
		$this->tasks = new Tasks($db);
		$this->data = $this->secureData(array_merge($_POST, $_GET, $_FILES));///Change kadm!
		
	}
	
	private function secureData($data){
		foreach($data as $key => $value) {
			if (is_array($value)) $this->secureData($value);
			else $data[$key] = htmlspecialchars($value);
		}
		return $data;
	}
	
	public function redirect($link) {
		header("Location: $link");
		exit;
	}

	public function login() {  
		
		$login = $this->data["login"];
		$password = $this->data["password"];
		$password = $this->hashPassword($password); 
		$r = $_SERVER["HTTP_REFERER"];
		if($this->user->Auth($login, $password)){
			$_SESSION["login"] = $login;
			$_SESSION["password"] = $password;
            $_SESSION["error_message"] = false;
			$this->redirect($r);
		}
		else {
            $_SESSION["error_message"] = true;
            $this->redirect($r);
		}
	
	}

	public function addTask(){
	    $r = $_SERVER['HTTP_REFERER'];
	    if (!$this->data['user_name'] || !$this->data['user_email'] || !$this->data['task_text']) {
            $_SESSION['add_task_error'] = true;
            $this->redirect($r);
        }
        $for_insert = [
            'user_name' => $this->data['user_name'],
            'user_email' => $this->data['user_email'],
            'task_text' => $this->data['task_text'],
            'finished'  => 0
        ];
        if($this->tasks->addTask($for_insert)){
            $_SESSION['add_task_error'] = false;
            $this->redirect($r);
        }
        else{
            $_SESSION['add_task_error'] = true;
            $this->redirect($r);
        }
    }

	public function logout() {
		unset($_SESSION["login"]);
		unset($_SESSION["password"]);
		$this->redirect($_SERVER["HTTP_REFERER"]);   
	}

	public function completedTask(){
	    $task_id = $this->data['completed_task'];
	    $this->tasks->completed($task_id);
	    $this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function editTask(){
	    $task_id = $this->data['edit_task'];
	    $upd_fields = [
	        'user_name' => $this->data['user_name'],
	        'user_email' => $this->data['user_email'],
	        'task_text' => $this->data['task_text'],
        ];
        $this->tasks->editTask($task_id, $upd_fields);
        $this->redirect($_SERVER['HTTP_REFERER']);
    }

	private function hashPassword($password){
		return md5($password.$this->config->secret);
	}

}

?>