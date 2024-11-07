<?php
    session_start();
    require_once '../db_handler/DB.php';
    require_once '../db_handler/Item.php';

    $myId = $_SESSION['userId'];

    $db = new Database("../database/database.db");

    $items = $db->getWishlistItems($myId);

    $json = json_encode($items);

    echo $json;
?>