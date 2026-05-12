<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
if(count($_POST)>0){
	$part = new PartData();
	$part->code = $_POST["code"];
	$part->name = $_POST["name"];
	$part->description = $_POST["description"];
	$part->quantity = $_POST["quantity"];
	$part->unit = $_POST["unit"];
	$part->price_in = $_POST["price_in"];
	$part->price_out = $_POST["price_out"];
	$part->category_id = $_POST["category_id"];
	$part->add();
	Core::alert("Item agregado al inventario!");
	Core::redir("./?view=parts&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="upd"){
if(count($_POST)>0){
	$part = PartData::getById($_POST["id"]);
	$part->code = $_POST["code"];
	$part->name = $_POST["name"];
	$part->description = $_POST["description"];
	$part->quantity = $_POST["quantity"];
	$part->unit = $_POST["unit"];
	$part->price_in = $_POST["price_in"];
	$part->price_out = $_POST["price_out"];
	$part->category_id = $_POST["category_id"];
	$part->is_active = $_POST["is_active"];
	$part->update();
	Core::alert("Item actualizado!");
	Core::redir("./?view=parts&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$part = PartData::getById($_GET["id"]);
	$part->del();
	Core::alert("Item eliminado!");
	Core::redir("./?view=parts&opt=all");
}
?>
