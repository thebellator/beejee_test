<?php
require_once "config_class.php";
require_once "checkvalid_class.php";
require_once "database_class.php";

abstract class GlobalClass {
	
	private $db;
	private $table_name;
	protected $config;
	protected $valid;
	
	protected function __construct($table_name, $db){
		$this->db = $db;
		$this->table_name = $table_name;
		$this->config = new Config();
		$this->valid = new CheckValid();
	}
	
	protected function add($new_values) {
		return $this->db->insert($this->table_name, $new_values);
	}
	
	protected function edit($id, $upd_fields){
		return $this->db->updateOnID($this->table_name, $id, $upd_fields);
	}
	
	public function delete($id) {
		return $this->db->deleteOnId($this->table_name, $id);
	}
	
	public function deleteAll(){
		return $this->db->deleteAll($this->table_name);
	}
	
	protected function getField($field_out, $field_in, $value_in) {
		return $this->db->getField($this->table_name, $field_out, $field_in, $value_in);
	}
	
	protected function getFields($fields){
		return $this->db->getFields($this->table_name,$fields);
	}
	
	protected function getFieldOnID($id, $field) {
		return $this->db->getFieldOnID($this->table_name, $id, $field);
	}
	
	protected function setFieldOnID($id, $field, $value) {
		return $this->db->setFieldOnID($this->table_name, $id, $field, $value);
	}
	
	public function get($id) {
		return $this->db->getElementOnID($this->table_name, $id);
	}
	
	public function getAll($order = "", $up = true, $limit = "") {
		return $this->db->getAll($this->table_name, $order, $up, $limit);  
	}
	
	protected function getAllOnField($field, $value, $order = "", $up = true) {
		return $this->db->getAllOnField($this->table_name, $field, $value, $order, $up);
	}
	
	protected function getAllByParam($where, $order = "", $up = true, $limit = "", $handle = false){
		return $this->db->getAllByParam($this->table_name, $where, $order, $up, $limit, $handle);
	} 

	public function getLastID(){
		return $this->db->getLastID($this->table_name);
	}
	
	public function getCount($where = ""){ 
		return $this->db->getCount($this->table_name, $where);
	}
	
	protected function isExists($field, $value) {
		return $this->db->isExists($this->table_name, $field, $value);
	}

}

?>