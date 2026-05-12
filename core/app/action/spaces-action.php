<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
if(count($_POST)>0){
	$space = new SpaceData();
	$space->name = $_POST["name"];
	$space->description = $_POST["description"];
	$space->add();
	Core::alert("Espacio agregado!");
	Core::redir("./?view=spaces&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="upd"){
if(count($_POST)>0){
	$space = SpaceData::getById($_POST["id"]);
	$space->name = $_POST["name"];
	$space->description = $_POST["description"];
	$space->is_active = $_POST["is_active"];
	$space->update();
	Core::alert("Espacio actualizado!");
	Core::redir("./?view=spaces&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$space = SpaceData::getById($_GET["id"]);
	$space->del();
	Core::alert("Espacio eliminado!");
	Core::redir("./?view=spaces&opt=all");
}
?>
