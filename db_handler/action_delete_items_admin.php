<?php

    session_start();

    if ($_SESSION['csrf'] !== $_POST['csrf_token']) {
        exit();
    }

    $itemId = $_POST['itemId'];

    require_once '../db_handler/DB.php';
    require_once '../db_handler/Item.php';

    $db = new Database("../database/database.db");

    $db->deleteItem($itemId);
    $db->deleteItemMessages($itemId);
    $db->deleteItemShoppingCart($itemId);
    $db->deleteItemWishlist($itemId);

    echo "success";

?>
