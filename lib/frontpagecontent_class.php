<?php
require_once "modules_class.php";

class FrontPageContent extends Modules {
	
	private $all_tasks;
	private $page;
	
	public function __construct($db) {  
		parent::__construct($db);
		$order = ($this->data["order"])??'id';
		$this->all_tasks = $this->tasks->getAll($order);
		$this->notPageFound($this->data["page"],count($this->all_tasks), $this->config->count_tasks);
		$this->page = (isset($this->data["page"]))? $this->data["page"]: 1;
	}
	
	protected function getTittle(){
		return ($this->page > 1)? "Главная - Страница".$this->page : "Главная - Страница";
	}

	protected function getMiddle() {
		return $this->getTasks($this->all_tasks, $this->page);
	}
	
	protected function getBottom() {
		return $this->getPagination(count($this->all_tasks), $this->config->count_tasks, $this->config->address);
	}
}
?>