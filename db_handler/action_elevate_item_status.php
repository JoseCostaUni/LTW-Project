<?php
    
    session_start();

    if ($_SESSION['csrf'] !== $_POST['csrf_token']) {
        exit();
    }

    $itemId = $_POST['itemId'];

    require_once '../db_handler/DB.php';
    require_once '../db_handler/Item.php';

    $db = new Database("../database/database.db");

    $item = $db->getItemById($itemId);

    $db->UpdateItemHighlighted($itemId,$item->getHighlighted() + 1);

    echo "success";

?>