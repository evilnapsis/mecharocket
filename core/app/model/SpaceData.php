<?php
class SpaceData {
	public static $tablename = "space";

	public $id;
	public $name;
	public $description;
	public $is_active;

	public function __construct(){
		$this->name = "";
		$this->description = "";
		$this->is_active = 1;
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (name,description,is_active) ";
		$sql .= "value (\"$this->name\",\"$this->description\",$this->is_active)";
		return Executor::doit($sql);
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\",description=\"$this->description\",is_active=$this->is_active where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new SpaceData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." order by name asc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SpaceData());
	}
}
?>
