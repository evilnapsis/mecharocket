<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
if(count($_POST)>0){
	$service = new ServiceData();
	$service->name = $_POST["name"];
	$service->description = $_POST["description"];
	$service->price = $_POST["price"];
	$service->add();
	Core::alert("Servicio agregado!");
	Core::redir("./?view=services&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="upd"){
if(count($_POST)>0){
	$service = ServiceData::getById($_POST["id"]);
	$service->name = $_POST["name"];
	$service->description = $_POST["description"];
	$service->price = $_POST["price"];
	$service->is_active = $_POST["is_active"];
	$service->update();
	Core::alert("Servicio actualizado!");
	Core::redir("./?view=services&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$service = ServiceData::getById($_GET["id"]);
	$service->del();
	Core::alert("Servicio eliminado!");
	Core::redir("./?view=services&opt=all");
}
?>
