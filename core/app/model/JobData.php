<?php
class JobData {
	public static $tablename = "job";

	public $id;
	public $operation_id;
	public $job_category_id;
	public $name;
	public $description;
	public $price;
	public $is_billable;
	public $status_id;
	public $mechanic_id;
	public $created_at;

	public function __construct(){
		$this->name = "";
		$this->description = "";
		$this->price = 0;
		$this->is_billable = 0;
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (operation_id,job_category_id,name,description,price,is_billable,status_id,mechanic_id,created_at) ";
		$sql .= "value ($this->operation_id,$this->job_category_id,\"$this->name\",\"$this->description\",$this->price,$this->is_billable,".($this->status_id?$this->status_id:"NULL").",".($this->mechanic_id?$this->mechanic_id:"NULL").",$this->created_at)";
		return Executor::doit($sql);
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set job_category_id=$this->job_category_id,name=\"$this->name\",description=\"$this->description\",price=$this->price,is_billable=$this->is_billable,status_id=".($this->status_id?$this->status_id:"NULL").",mechanic_id=".($this->mechanic_id?$this->mechanic_id:"NULL")." where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new JobData());
	}

	public static function getAllByOperationId($id){
		$sql = "select * from ".self::$tablename." where operation_id=$id order by created_at asc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new JobData());
	}

	public function getCategory(){ return JobCategoryData::getById($this->job_category_id); }
	public function getStatus(){ return $this->status_id ? StatusData::getById($this->status_id) : null; }
	public function getMechanic(){ return $this->mechanic_id ? UserData::getById($this->mechanic_id) : null; }
}
?>
