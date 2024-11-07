<?php 
    require_once '../db_handler/DB.php';
    require_once '../db_handler/Item.php';

    $db = new Database("../database/database.db");

    $id = $_POST['id'];

    $db->deleteSizeById($id);
?>  
