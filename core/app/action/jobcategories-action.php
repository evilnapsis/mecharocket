<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
if(count($_POST)>0){
	$jc = new JobCategoryData();
	$jc->name = $_POST["name"];
	$jc->add();
	Core::alert("Área de trabajo agregada!");
	Core::redir("./?view=jobcategories&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="upd"){
if(count($_POST)>0){
	$jc = JobCategoryData::getById($_POST["id"]);
	$jc->name = $_POST["name"];
	$jc->is_active = $_POST["is_active"];
	$jc->update();
	Core::alert("Área de trabajo actualizada!");
	Core::redir("./?view=jobcategories&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$jc = JobCategoryData::getById($_GET["id"]);
	$jc->del();
	Core::alert("Área de trabajo eliminada!");
	Core::redir("./?view=jobcategories&opt=all");
}
?>
