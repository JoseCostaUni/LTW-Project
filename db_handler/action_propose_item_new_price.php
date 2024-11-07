<?php

   session_start();

   if ($_SESSION['csrf'] !== $_POST['csrf_token']) {
    exit();
   }
   
   require_once '../db_handler/DB.php';

   $itemId = $_POST['itemId'];
   $proposal = $_POST['proposal'];
   $userId = $_SESSION['userId'];

    require_once '../db_handler/DB.php';
    require_once '../db_handler/Item.php';

    $db = new Database("../database/database.db");

    $db->InsertItemProposal($itemId, $userId, $proposal);

    echo "success"
?>