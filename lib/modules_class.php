<?php

require_once "config_class.php";
//USER REQUIRE
require_once "user_class.php";
//TASKS REQUIRE
require_once "tasks_class.php";



abstract class Modules {
	
	protected $config;
	//User Data
    protected $user;
    protected $user_info;
	//TASKS BLOCK
    protected  $tasks;
    //Request data GET
    protected $data;

	
	public function __construct($db) { 
		session_start();
		$this->config = new Config();
		$this->user = new User($db);
		//TASKS OBJECT
        $this->tasks = new Tasks($db);

		$this->data = $this->secureData($_GET);
		$this->user_info = $this->getUser();
		
	}
	
	public function getUser() { 
		$login = $_SESSION["login"];
		$password = $_SESSION["password"];
		return ($this->user->Auth($login, $password))?? false;
	}
	
	public function getContent() {
		$sr["head"] = $this->getHead();
        $sr["middle"] = $this->getMiddle();
        $sr["foot"] = $this->getFoot();
		return $this->getReplaceTemplate($sr,"main");
	}
	
	abstract protected function getTittle();
	abstract protected function getMiddle();

	
	////////////////////////////////////////////////////////////////////////////////////////////////////

	protected function getHead(){
		$sr["title"] = $this->getTittle();
        $sr["sign_in"] = ($this->user_info)? '<li ><a href="/functions.php/?logout=1">Выйти</a></li>' : '<li ><a href="/?view=auth">Войти</a></li>';
		return $this->getReplaceTemplate($sr, "head");  
	}
	
	protected function getFoot(){
        $sr['bottom'] = $this->getBottom();
		return $this->getReplaceTemplate($sr, "foot");
	}

	protected function getBottom(){
		return "";
	}
	
	protected function getTasks($tasks, $page) {
		$start = ($page - 1) * $this->config->count_tasks;
		$end = (count($tasks) > $start + $this->config->count_tasks)? $start + $this->config->count_tasks: count($tasks);
		for ($i = $start; $i < $end; $i++) {
			$task_id = $tasks[$i]["id"];
			$sr["user_name"] = $tasks[$i]["user_name"];
			$sr["user_email"] = $tasks[$i]["user_email"];
			$sr["task_text"] = substr($tasks[$i]["task_text"], 0, 100);
			$sr["finished"] = ((int)$tasks[$i]["finished"] === 1)? '<i class="fa fa-check"></i>' : '';
			$sr["link_task"] = $this->config->address."?view=task&amp;id=".$task_id;
			$text .=$this->getReplaceTemplate($sr, "task");
		}
		return $text;
		
	}
	
	protected function getPagination($count, $count_on_page, $link){
		$count_pages = ceil($count / $count_on_page);
		$sr["number"] = 1;
		$sr["link"] = $link;
		$pages = $this->getReplaceTemplate($sr, "number_page");
		$sym = (strpos($link, "?") !== false)? "&amp;": "?";
		for ($i = 2; $i <= $count_pages; $i++) {
			$sr["number"] = $i;
			$sr["link"] = $link.$sym."page=$i"; 
			$pages .= $this->getReplaceTemplate($sr, "number_page");
		}
		
		$els["number_pages"] = $pages;
		return $this->getReplaceTemplate($els, "pagination");
	}


	private function secureData($data){
		foreach($data as $key => $value) {
			if (is_array($value)) $this->secureData($value);
			else $data[$key] = htmlspecialchars($value);
		}
		return $data;
	}
	
	protected function getTemplate($name) {
		$text = file_get_contents($this->config->dir_tmpl.$name.".tpl");
		return str_replace("%address%", $this->config->address, $text);
	}
	
	protected function getReplaceTemplate($sr, $template) {
		return $this->getReplaceContent($sr, $this->getTemplate($template));
	}
	
	private function getReplaceContent($sr, $content) {
		$search = array();
		$replace = array();
		$i = 0;
		foreach ($sr as $key => $value) {
			$search[$i] = "%$key%";
			$replace[$i] = $value;
			$i++;
		} 
		return str_replace($search, $replace, $content);
	}
	
	protected function redirect($link) {
		header("Location: $link");
		exit;
	}
	
	protected function notPageFound($p,$count, $count_on_page){
		$count_pages = ceil($count / $count_on_page);
		$page = $p;
		if ($page < 1 and $page != "") $this->notFound();
		elseif($page > $count_pages) $this->notFound();
		else return true;
	}
	
	protected function notFound() {
		$this->redirect($this->config->address."?view=notfound");
	}
}


?>