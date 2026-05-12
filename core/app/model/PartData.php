<?php
class PartData {
	public static $tablename = "part";

	public $id;
	public $name;
	public $code;
	public $description;
	public $quantity;
	public $unit;
	public $price_in;
	public $price_out;
	public $category_id;
	public $is_active;
	public $created_at;

	public function __construct(){
		$this->name = "";
		$this->code = "";
		$this->description = "";
		$this->quantity = 0;
		$this->unit = "Pieza";
		$this->price_in = 0;
		$this->price_out = 0;
		$this->is_active = 1;
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (name,code,description,quantity,unit,price_in,price_out,category_id,is_active,created_at) ";
		$sql .= "value (\"$this->name\",\"$this->code\",\"$this->description\",\"$this->quantity\",\"$this->unit\",\"$this->price_in\",\"$this->price_out\",$this->category_id,$this->is_active,$this->created_at)";
		return Executor::doit($sql);
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\",code=\"$this->code\",description=\"$this->description\",quantity=\"$this->quantity\",unit=\"$this->unit\",price_in=\"$this->price_in\",price_out=\"$this->price_out\",category_id=$this->category_id,is_active=$this->is_active where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new PartData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." order by name asc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PartData());
	}

	public static function getAllByQ($q){
		$sql = "select * from ".self::$tablename." $q";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PartData());
	}

	public function getCategory(){ return CategoryData::getById($this->category_id); }
}
?>
