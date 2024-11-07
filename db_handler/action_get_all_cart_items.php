<?php
session_start();
require_once '../db_handler/DB.php';
require_once '../db_handler/Item.php';

$user = $_SESSION['userId'];

$db = new Database("../database/database.db");

$items = $db->getcartitems($user);


$json = json_encode($items);

echo $json;
?>