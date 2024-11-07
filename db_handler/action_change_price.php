<?php
session_start();

if ($_SESSION['csrf'] !== $_POST['csrf_token']) {
    exit();
}

if(isset($_POST['itemId']) && isset($_POST['type'])){
    $itemId = $_POST['itemId'];
    $type = $_POST['type'];

    require_once 'DB.php';
    require_once 'Item.php';
    $db = new Database("../database/database.db");
    $priceProposal = $db->getPriceProposalByUserId($itemId);
    $newPrice = $priceProposal->getPrice();

    if($type == "reject"){
        $db->EliminateItemProposal($itemId,$newPrice);
        echo "success";

    } else if($type == "accept"){
        $db->UpdateItemPrice($itemId,$newPrice);
        $db->EliminateItemProposal($itemId,$newPrice);
        echo "success";

    } else {
        echo "error";
    }
} else {
    echo "error: missing parameters";
}


?>