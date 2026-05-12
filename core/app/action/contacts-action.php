<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
if(count($_POST)>0){
	$contact = new ContactData();
	$contact->name = $_POST["name"];
	$contact->lastname = $_POST["lastname"];
	$contact->email = $_POST["email"];
	$contact->phone = $_POST["phone"];
	$contact->address = $_POST["address"];
	$contact->company = $_POST["company"];
	$contact->type = $_POST["type"];
	$contact->description = $_POST["description"];
	$contact->add();
	Core::alert("Contacto agregado!");
	Core::redir("./?view=contacts&opt=all&type=$contact->type");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="upd"){
if(count($_POST)>0){
	$contact = ContactData::getById($_POST["id"]);
	$contact->name = $_POST["name"];
	$contact->lastname = $_POST["lastname"];
	$contact->email = $_POST["email"];
	$contact->phone = $_POST["phone"];
	$contact->address = $_POST["address"];
	$contact->company = $_POST["company"];
	$contact->type = $_POST["type"];
	$contact->description = $_POST["description"];
	$contact->is_active = $_POST["is_active"];
	$contact->update();
	Core::alert("Contacto actualizado!");
	Core::redir("./?view=contacts&opt=all&type=$contact->type");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="add_ajax"){
if(count($_POST)>0){
	$contact = new ContactData();
	$contact->name = $_POST["name"] ?? "";
	$contact->lastname = $_POST["lastname"] ?? "";
	$contact->email = $_POST["email"] ?? "";
	$contact->phone = $_POST["phone"] ?? "";
	$contact->address = $_POST["address"] ?? "";
	$contact->company = $_POST["company"] ?? "";
	$contact->type = 1; // Client
	$contact->description = "Agregado desde Orden de Servicio";
	$res = $contact->add();
	$new_id = $res[1];
	header('Content-Type: application/json');
	echo json_encode(["status"=>"success", "id"=>$new_id, "name"=>$contact->name." ".$contact->lastname]);
	die();
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$contact = ContactData::getById($_GET["id"]);
	$type = $contact->type;
	$contact->del();
	Core::alert("Contacto eliminado!");
	Core::redir("./?view=contacts&opt=all&type=$type");
}
?>
