<?php
class Db {

	public $db;

	public function __construct($db){
		$this->db = new SQLite3($db);
		$this->init();
	}

	private function init(){
		//$this->dropStudentTable();
		$this->createStudentTable();
	}


	public function createStudentTable(){
		return $this->db->exec('CREATE TABLE IF NOT EXISTS tiendas (name STRING, precio DOUBLE)');
	}

	public function dropStudentTable(){
		return $this->db->exec('DROP TABLE tiendas');
	}

	public function insert($name, $precio){
		return $this->db->exec("INSERT INTO tiendas (name, precio) VALUES ('$name', $precio)");
	}

	public function update($id, $name, $precio){
		return $this->db->query("UPDATE tiendas set name='$name', precio='$precio' WHERE rowid=$id");
	}

	public function delete($id){
		return $this->db->query("DELETE FROM tiendas WHERE rowid=$id");
	}

	public function getAll($condition=""){
		$result = $this->db->query("SELECT rowid, * FROM tiendas $condition");
		$rows = array();
		while ($row = $result->fetchArray()) {
			$rows[] = $row;
		}
		return $rows;
	}

	public function getById($id){
		return $this->db->query("SELECT rowid, * FROM tiendas WHERE rowid=$id")->fetchArray();
	}
}

?>
