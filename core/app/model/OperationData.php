<?php
class OperationData {
	public static $tablename = "operation";

	public $id;
	public $description;
	public $vehicle_id;
	public $contact_id;
	public $user_id;
	public $mechanic_id;
	public $status_id;
	public $space_id;
	public $start_date;
	public $end_date;
	public $total;
	public $kind; /* 1. Repair, 2. Budget, 3. Sale, 4. Purchase */
	public $created_at;

	public function __construct(){
		$this->description = "";
		$this->start_date = "NULL";
		$this->end_date = "NULL";
		$this->total = 0;
		$this->kind = 1;
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (description,vehicle_id,contact_id,user_id,mechanic_id,status_id,space_id,start_date,end_date,total,kind,created_at) ";
		$sql .= "value (\"$this->description\",".($this->vehicle_id?$this->vehicle_id:"NULL").",".($this->contact_id?$this->contact_id:"NULL").",$this->user_id,".($this->mechanic_id?$this->mechanic_id:"NULL").",".($this->status_id?$this->status_id:"NULL").",".($this->space_id?$this->space_id:"NULL").",".($this->start_date!="NULL"?"\"$this->start_date\"":"NULL").",".($this->end_date!="NULL"?"\"$this->end_date\"":"NULL").",$this->total,$this->kind,$this->created_at)";
		return Executor::doit($sql);
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set description=\"$this->description\",vehicle_id=".($this->vehicle_id?$this->vehicle_id:"NULL").",contact_id=".($this->contact_id?$this->contact_id:"NULL").",user_id=$this->user_id,mechanic_id=".($this->mechanic_id?$this->mechanic_id:"NULL").",status_id=".($this->status_id?$this->status_id:"NULL").",space_id=".($this->space_id?$this->space_id:"NULL").",start_date=".($this->start_date!="NULL"?"\"$this->start_date\"":"NULL").",end_date=".($this->end_date!="NULL"?"\"$this->end_date\"":"NULL").",total=$this->total,kind=$this->kind where id=$this->id";
		Executor::doit($sql);
	}

	public function update_total(){
		$sql = "update ".self::$tablename." set total=$this->total where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new OperationData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new OperationData());
	}

	public static function getAllByQ($q){
		$sql = "select * from ".self::$tablename." $q";
		$query = Executor::doit($sql);
		return Model::many($query[0],new OperationData());
	}

	public function getVehicle(){ return $this->vehicle_id ? VehicleData::getById($this->vehicle_id) : null; }
	public function getContact(){ return $this->contact_id ? ContactData::getById($this->contact_id) : null; }
	public function getUser(){ return $this->user_id ? UserData::getById($this->user_id) : null; }
	public function getMechanic(){ return $this->mechanic_id ? UserData::getById($this->mechanic_id) : null; }
	public function getStatus(){ return $this->status_id ? StatusData::getById($this->status_id) : null; }
	public function getSpace(){ return $this->space_id ? SpaceData::getById($this->space_id) : null; }
}
?>
