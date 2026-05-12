<?php
class JobCategoryData {
	public static $tablename = "job_category";

	public $id;
	public $name;
	public $is_active;

	public function __construct(){
		$this->name = "";
		$this->is_active = 1;
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (name,is_active) ";
		$sql .= "value (\"$this->name\",$this->is_active)";
		return Executor::doit($sql);
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\",is_active=$this->is_active where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new JobCategoryData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." order by name asc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new JobCategoryData());
	}
}
?>
