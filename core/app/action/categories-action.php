<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
if(count($_POST)>0){
	$category = new CategoryData();
	$category->name = $_POST["name"];
	$category->add();
	Core::alert("Categoría agregada!");
	Core::redir("./?view=categories&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="upd"){
if(count($_POST)>0){
	$category = CategoryData::getById($_POST["id"]);
	$category->name = $_POST["name"];
	$category->is_active = $_POST["is_active"];
	$category->update();
	Core::alert("Categoría actualizada!");
	Core::redir("./?view=categories&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$category = CategoryData::getById($_GET["id"]);
	$category->del();
	Core::alert("Categoría eliminada!");
	Core::redir("./?view=categories&opt=all");
}
?>
