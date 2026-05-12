<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="upd"){
    if(count($_POST)>0){
        ConfigurationData::updateValByShort("workshop_name", $_POST["workshop_name"]);
        ConfigurationData::updateValByShort("workshop_manager", $_POST["workshop_manager"]);
        ConfigurationData::updateValByShort("workshop_address", $_POST["workshop_address"]);
        ConfigurationData::updateValByShort("workshop_phone", $_POST["workshop_phone"]);

        if(isset($_FILES["logo"]) && $_FILES["logo"]["name"] != ""){
            $dest = "storage/branding/";
            if(!file_exists($dest)){ mkdir($dest, 0777, true); }
            
            $file_name = time() . "_" . $_FILES["logo"]["name"];
            move_uploaded_file($_FILES["logo"]["tmp_name"], $dest . $file_name);
            ConfigurationData::updateValByShort("workshop_logo", $file_name);
        }

        Core::alert("Configuración actualizada correctamente!");
        Core::redir("./?view=settings");
    }
}
?>
