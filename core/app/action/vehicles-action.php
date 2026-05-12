<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
if(count($_POST)>0){
	$vehicle = new VehicleData();
	$vehicle->plate = $_POST["plate"];
	$vehicle->vin = $_POST["vin"];
	$vehicle->brand = $_POST["brand"];
	$vehicle->model = $_POST["model"];
	$vehicle->year = $_POST["year"];
	$vehicle->color = $_POST["color"];
	$vehicle->contact_id = $_POST["contact_id"];
	$vehicle->description = $_POST["description"];
	$vehicle->add();
	Core::alert("Vehículo agregado!");
	Core::redir("./?view=vehicles&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="upd"){
if(count($_POST)>0){
	$vehicle = VehicleData::getById($_POST["id"]);
	$vehicle->plate = $_POST["plate"];
	$vehicle->vin = $_POST["vin"];
	$vehicle->brand = $_POST["brand"];
	$vehicle->model = $_POST["model"];
	$vehicle->year = $_POST["year"];
	$vehicle->color = $_POST["color"];
	$vehicle->contact_id = $_POST["contact_id"];
	$vehicle->description = $_POST["description"];
	$vehicle->update();
	Core::alert("Vehículo actualizado!");
	Core::redir("./?view=vehicles&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="add_ajax"){
if(count($_POST)>0){
	$vehicle = new VehicleData();
	$vehicle->plate = $_POST["plate"] ?? "";
	$vehicle->vin = $_POST["vin"] ?? "";
	$vehicle->brand = $_POST["brand"] ?? "";
	$vehicle->model = $_POST["model"] ?? "";
	$vehicle->year = $_POST["year"] ?? "";
	$vehicle->color = $_POST["color"] ?? "";
	$vehicle->contact_id = $_POST["contact_id"] ?? "";
	$vehicle->description = "Agregado desde Orden de Servicio";
	$res = $vehicle->add();
	$new_id = $res[1];
	header('Content-Type: application/json');
	echo json_encode(["status"=>"success", "id"=>$new_id, "plate"=>$vehicle->plate, "brand"=>$vehicle->brand, "model"=>$vehicle->model]);
	die();
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="get_all_ajax"){
	$vehicles = [];
	if(isset($_GET["contact_id"]) && $_GET["contact_id"] != ""){
		$vehicles = VehicleData::getAllBy("contact_id", $_GET["contact_id"]);
	} else {
		$vehicles = VehicleData::getAll();
	}
	$data = [];
	foreach($vehicles as $v){
		$c = $v->getContact();
		$data[] = [
			"id" => $v->id,
			"plate" => $v->plate,
			"brand" => $v->brand,
			"model" => $v->model,
			"contact_id" => $v->contact_id,
			"contact_name" => $c ? $c->name : "N/A"
		];
	}
	header('Content-Type: application/json');
	echo json_encode($data);
	die();
}
?>
