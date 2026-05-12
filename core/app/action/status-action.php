<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
if(count($_POST)>0){
	$status = new StatusData();
	$status->name = $_POST["name"];
	$status->color = $_POST["color"];
	$status->add();
	Core::alert("Estado agregado!");
	Core::redir("./?view=status&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="upd"){
if(count($_POST)>0){
	$status = StatusData::getById($_POST["id"]);
	$status->name = $_POST["name"];
	$status->color = $_POST["color"];
	$status->update();
	Core::alert("Estado actualizado!");
	Core::redir("./?view=status&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$status = StatusData::getById($_GET["id"]);
	$status->del();
	Core::alert("Estado eliminado!");
	Core::redir("./?view=status&opt=all");
}
?>
