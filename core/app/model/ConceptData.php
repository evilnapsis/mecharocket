<?php
class ConceptData {
	public static $tablename = "concept";

	public $id;
	public $name;
	public $description;
	public $price;
	public $image;

	public function __construct(){
		$this->name = "";
		$this->description = "";
		$this->price = 0;
		$this->image = "";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (name,description,price,image) ";
		$sql .= "value (\"$this->name\",\"$this->description\",$this->price,\"$this->image\")";
		return Executor::doit($sql);
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\",price=$this->price where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ConceptData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." order by name asc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ConceptData());
	}

	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ConceptData());
	}
}
?>
