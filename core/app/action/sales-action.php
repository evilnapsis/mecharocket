<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
    if(count($_POST)>0){
        $op = new OperationData();
        $op->contact_id = $_POST["contact_id"] != "" ? $_POST["contact_id"] : "NULL";
        $op->description = $_POST["description"];
        $op->user_id = $_SESSION["user_id"];
        $op->kind = 3; // Sale
        $op->total = 0;
        $res = $op->add();
        $op_id = $res[1];

        $total = 0;
        if(isset($_POST["item_id"])){
            foreach($_POST["item_id"] as $key => $item_id){
                if($item_id != ""){
                    $qty = $_POST["quantity"][$key];
                    $price = $_POST["price"][$key];
                    
                    $detail = new OperationDetailData();
                    $detail->operation_id = $op_id;
                    $detail->part_id = $item_id;
                    $detail->quantity = $qty;
                    $detail->price = $price;
                    $detail->add();

                    // Update Stock (Subtract)
                    $part = PartData::getById($item_id);
                    $part->quantity = $part->quantity - $qty;
                    $part->update();

                    $total += ($qty * $price);
                }
            }
        }

        $op_final = OperationData::getById($op_id);
        $op_final->total = $total;
        $op_final->update_total();

        Core::alert("Venta procesada exitosamente!");
        Core::redir("./?view=sales&opt=all");
    }
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
    $op = OperationData::getById($_GET["id"]);
    $op->del();
    Core::alert("Venta eliminada!");
    Core::redir("./?view=sales&opt=all");
}
?>
