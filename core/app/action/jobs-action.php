<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
if(count($_POST)>0){
	$j = new JobData();
	$j->operation_id = $_POST["operation_id"];
	$j->job_category_id = $_POST["job_category_id"];
	$j->name = $_POST["name"];
	$j->description = $_POST["description"];
	$j->price = $_POST["price"];
	$j->is_billable = isset($_POST["is_billable"]) ? 1 : 0;
	$j->status_id = 1; // Pending by default
	$j->add();

  // If billable, update operation total
  if($j->is_billable){
    $op = OperationData::getById($j->operation_id);
    $op->total += $j->price;
    $op->update_total();
  }

	Core::alert("Tarea agregada!");
	Core::redir("./?view=operations&opt=details&id=".$j->operation_id);
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$j = JobData::getById($_GET["id"]);
  $op_id = $j->operation_id;

  // If was billable, deduct from operation total
  if($j->is_billable){
    $op = OperationData::getById($op_id);
    $op->total -= $j->price;
    $op->update_total();
  }

	$j->del();
	Core::alert("Tarea eliminada!");
	Core::redir("./?view=operations&opt=details&id=".$op_id);
}
?>
