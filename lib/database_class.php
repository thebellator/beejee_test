<?php
require_once "config_class.php";
require_once "checkvalid_class.php";

class Database {
	
	private $config;
	private $mysqli;
	private $valid;
	
	public function __construct() {
		$this->config = new Config();
		$this->valid = new CheckValid();
		$this->mysqli = new mysqli($this->config->host, $this->config->user, $this->config->password, $this->config->db);
		$this->mysqli->query("SET NAMES 'utf8'");
	}
	
	private function query($query) {
		return $this->mysqli->query($query);
	}
	
	private function select($table_name, $fields, $where = "", $order = "", $up = true, $limit = ""){
		for ($i = 0; $i < count($fields); $i++) {
			if ((strpos($fields[$i], "(") === false) && ($fields[$i] != "*")) $fields[$i] = "`".$fields[$i]."`";
		}
		$fields = implode(",", $fields);
		$table_name = $this->config->db_prefix.$table_name;
		if (!$order) $order = "ORDER BY `id`";
		else {
			if ($order != "RAND()"){
				$order = "ORDER BY `$order`";
				if (!$up) $order .= " DESC";
			}
			else $order = "ORDER BY $order";
		}
		if ($limit) $limit = "LIMIT $limit";
		if ($where) $query = "SELECT $fields FROM $table_name WHERE $where $order $limit";
		else $query = "SELECT $fields FROM $table_name $order $limit";
		$result_set =$this->query($query);
		if (!$result_set) return false;
		$i = 0;
		while ($row = $result_set->fetch_assoc()) {
			$data[$i] = $row;
			$i++;
		}
		$result_set->close();
		return $data;
	}
	
	public function insert($table_name, $new_values) {
		$table_name = $this->config->db_prefix.$table_name;
		$query = "INSERT INTO $table_name (";
		foreach ($new_values as $field => $value) $query .= "`".$field."`,";
		$query = substr($query, 0, -1);
		$query .= ") VALUES (";
		foreach ($new_values as $value) $query .= "'".addslashes($value)."',";
		$query = substr($query, 0,-1);
		$query .= ")";
		return $this->query($query);
	}
	
	private function update($table_name, $upd_fields, $where) {
		$table_name = $this->config->db_prefix.$table_name;
		$query = "UPDATE $table_name SET ";
		foreach ($upd_fields as $field=>$value) $query .= "`$field` = '".addslashes($value)."',";
		$query = substr($query, 0, -1);
		if ($where) {
			$query .= " WHERE $where";
			return $this->query($query);
		}
		else return false;
	}

	public function updateOnID($table_name, $id, $upd_fields){
		return $this->updateArticle($table_name,$upd_fields,"`id`= $id"); 
	} 
	
	public function delete ($table_name, $where = "") {
		$table_name = $this->config->db_prefix.$table_name;
		if ($where) {
			$query = "DELETE FROM $table_name WHERE $where";
			return $this->query($query);
		}
		else return false;
	}
	
	public function dleteAll ($table_name) {
		$table_name = $this->config->db_prefix.$table_name;
		$query = "TRUNCATE TABLE `$table_name`";
		return $this->query($query);
	}
	
	public function getField($table_name, $field_out, $field_in, $value_in) {
		$data = $this->select($table_name, array($field_out), "`$field_in`='".addslashes($value_in)."'");
		if (count($data) != 1) return false;
		return $data[0][$field_out];
	}
	
	public function getFields($table_name,$fields){
		$data = $this->select($table_name,$fields);
		if(!$data) return false;
		return $data; 
	}
	
	public function getFieldOnID($table_name, $id, $field_out) {
		if (!$this->existsID($table_name, $id)) return false;
		return $this->getField($table_name, $field_out, "id", $id);
	}
	
	public function getAll($table_name, $order, $up, $limit) {
		return $this->select($table_name, array("*"), "", $order, $up, $limit);
	}
	
	public function getAllOnField($table_name, $field, $value, $order, $up) {
		return $this->select($table_name, array("*"), "`$field`='".addslashes($value)."'", $order, $up);
	}
	
	public function getAllByParam($table_name, $where, $order, $up, $limit, $handle){
		if(!$handle){
		foreach($where as $key => $value){
		$wher .= "`$key`='".addslashes($value)."' AND ";
		}
		$last = strripos($wher,"AND");
		$wher = substr($wher,0,$last);
		}
		else $wher = $where;  
		//echo $wher;
		return $this->select($table_name, array("*"), $wher, $order, $up, $limit);
	}
	
	public function getLastID($table_name){
		$data = $this->select($table_name, array("MAX(`id`)"));
		return $data[0]["MAX(`id`)"];
	}
	
	public function deleteOnID($table_name, $id){
		if (!$this->existsID($table_name, $id)) return false;
		return $this->delete($table_name, "`id` = '$id'");
	}
	
	public function setField($table_name, $field, $value, $field_in, $value_in) {
		return $this->update($table_name, array($field => $value), "`$field_in` = '".addslashes($value_in)."'");
	}
	
	public function setFieldOnID($table_name, $id, $field, $value) {
		if (!$this->existsID($table_name, $id)) return false;
		return $this->setField($table_name, $field, $value, "id", $id);
	}
	
	public function getElementOnID($table_name, $id){
		if (!$this->existsID($table_name, $id)) return false;
		$arr = $this->select($table_name, array("*"), "`id` = '$id'");
		return $arr[0];
	}
	
	public function getRandomElements($table_name, $count) {
		return $this->select($table_name, array("*"), "", "RAND()", true, $count);
	}
	
	public function getCount($table_name, $where) {
		$data = $this->select($table_name, array("COUNT(`id`)"), $where);
		return $data[0]["COUNT(`id`)"];
	}
	
	public function isExists($table_name, $field, $value) {
		$data = $this->select($table_name, array("id"), "`$field` = '".addslashes($value)."'");
		if (count($data) === 0) return false;
		return true;
	}
	
	private function existsID($table_name, $id) {
		if (!$this->valid->validID($id)) return false;
		$data = $this->select($table_name, array("id"), "`id`='".addslashes($id)."'");
		if (count($data) === 0) return false;
		return true;
	}
	
	public function getMaxID($table_name){
		$max=$this->select($table_name, array("id"));
		if(!$max) return false;
		return count($max);
	}
	

	public function getMinValue($table_name,$field){
		$max_id=$this->getMaxID($table_name);
		$min_id=$max_id-($max_id-1);
		$min=$this->select($table_name, array(addslashes($field)),"`id`='$min_id'");
		if (!$min) return false;
		return $min;
	}

	public function getIntervalValue($table_name,$d,$m,$y,$dd,$mm,$yy,$field="*"){
		$from=mktime(0, 0, 0,$m,$d,$y);
		$to=mktime(23, 59, 59,$mm,$dd,$yy);
		$get=$this->select($table_name, array(addslashes($field))," `date` BETWEEN '$from' AND '$to'");
		if(!$get) return "EROR or not correct form(d,m,Y) DATE";
		return $get;
	} 
	
	public function __destruct(){
		if ($this->mysqli) $this->mysqli->close();
	}
	
} 

?>