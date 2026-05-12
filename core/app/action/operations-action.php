<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
if(count($_POST)>0){
	$op = new OperationData();
	$op->vehicle_id = $_POST["vehicle_id"];
  $vehicle = VehicleData::getById($op->vehicle_id);
	$op->contact_id = $vehicle->contact_id;
	$op->user_id = $_SESSION["user_id"];
	$op->mechanic_id = $_POST["mechanic_id"]!="" ? $_POST["mechanic_id"] : NULL;
	$op->status_id = $_POST["status_id"];
	$op->space_id = $_POST["space_id"];
	$op->start_date = $_POST["start_date"]!="" ? $_POST["start_date"] : "NULL";
	$op->end_date = $_POST["end_date"]!="" ? $_POST["end_date"] : "NULL";
	$op->description = $_POST["description"];
	$op->total = 0;
	$res = $op->add();
	Core::alert("Orden de servicio creada exitosamente!");
	Core::redir("./?view=operations&opt=details&id=".$res[1]);
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="upd"){
if(count($_POST)>0){
	$op = OperationData::getById($_POST["id"]);
	$op->vehicle_id = $_POST["vehicle_id"];
  $vehicle = VehicleData::getById($op->vehicle_id);
	$op->contact_id = $vehicle->contact_id;
	$op->mechanic_id = $_POST["mechanic_id"]!="" ? $_POST["mechanic_id"] : NULL;
	$op->status_id = $_POST["status_id"];
	$op->space_id = $_POST["space_id"];
	$op->start_date = $_POST["start_date"]!="" ? $_POST["start_date"] : "NULL";
	$op->end_date = $_POST["end_date"]!="" ? $_POST["end_date"] : "NULL";
	$op->description = $_POST["description"];
	$op->update();
	Core::alert("Orden de servicio actualizada!");
	Core::redir("./?view=operations&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$op = OperationData::getById($_GET["id"]);
	$op->del();
	Core::alert("Orden de servicio eliminada!");
	Core::redir("./?view=operations&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="upd_status"){
	$op = OperationData::getById($_POST["id"]);
	$op->status_id = $_POST["status_id"];
	$op->space_id = $_POST["space_id"];
	$op->update();
	Core::alert("Estado actualizado!");
	Core::redir("./?view=operations&opt=details&id=".$op->id);
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="add_detail"){
	$op = OperationData::getById($_POST["operation_id"]);
	$detail = new OperationDetailData();
	$detail->operation_id = $_POST["operation_id"];
	$detail->service_id = isset($_POST["service_id"]) && $_POST["service_id"]!="" ? $_POST["service_id"] : NULL;
	$detail->part_id = isset($_POST["part_id"]) && $_POST["part_id"]!="" ? $_POST["part_id"] : NULL;
	$detail->quantity = $_POST["quantity"];
	
	if($_POST["price"]!="" && $_POST["price"]>0){
		$detail->price = $_POST["price"];
	}else{
		if($detail->service_id){
			$detail->price = ServiceData::getById($detail->service_id)->price;
		}else if($detail->part_id){
			$detail->price = PartData::getById($detail->part_id)->price_out;
		}
	}

	$detail->add();

	// Update total in operation
	$op->total += ($detail->price * $detail->quantity);
	$op->update_total();

	Core::alert("Item agregado!");
	Core::redir("./?view=operations&opt=details&id=".$op->id);
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del_detail"){
	$detail = OperationDetailData::getById($_GET["id"]);
	$op = OperationData::getById($_GET["op_id"]);
	$op->total -= ($detail->price * $detail->quantity);
	$op->update_total();
	$detail->del();
	Core::alert("Item eliminado!");
	Core::redir("./?view=operations&opt=details&id=".$op->id);
}
?>
