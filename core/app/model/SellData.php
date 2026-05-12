<?php
class SellData {
	public static $tablename = "sell";

	public $id;
	public $concept_id;
	public $alumn_id;
	public $created_at;

	public function __construct(){
		$this->concept_id = 0;
		$this->alumn_id = 0;
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (concept_id,alumn_id,created_at) ";
		$sql .= "value ($this->concept_id,$this->alumn_id,$this->created_at)";
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

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new SellData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getAllByAlumnId($alumn_id){
		$sql = "select * from ".self::$tablename." where alumn_id=$alumn_id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public function getConcept(){
		return ConceptData::getById($this->concept_id);
	}

	public function getAlumn(){
		return PersonData::getById($this->alumn_id);
	}
}
?>
