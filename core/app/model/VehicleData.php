<?php
class VehicleData {
	public static $tablename = "vehicle";

	public $id;
	public $plate;
	public $vin;
	public $brand;
	public $model;
	public $year;
	public $color;
	public $contact_id;
	public $description;
	public $created_at;

	public function __construct(){
		$this->plate = "";
		$this->vin = "";
		$this->brand = "";
		$this->model = "";
		$this->color = "";
		$this->description = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (plate,vin,brand,model,year,color,contact_id,description,created_at) ";
		$sql .= "value (\"$this->plate\",\"$this->vin\",\"$this->brand\",\"$this->model\",\"$this->year\",\"$this->color\",$this->contact_id,\"$this->description\",$this->created_at)";
		return Executor::doit($sql);
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set plate=\"$this->plate\",vin=\"$this->vin\",brand=\"$this->brand\",model=\"$this->model\",year=\"$this->year\",color=\"$this->color\",contact_id=$this->contact_id,description=\"$this->description\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		if($id=="" || $id==null){ return null; }
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new VehicleData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new VehicleData());
	}

	public static function getAllBy($k,$v){
		$sql = "select * from ".self::$tablename." where $k=\"$v\" order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new VehicleData());
	}

	public static function getAllByContactId($id){
		return self::getAllBy("contact_id", $id);
	}

	public function getContact(){ return ContactData::getById($this->contact_id); }
}
?>
