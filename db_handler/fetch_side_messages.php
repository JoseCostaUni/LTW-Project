<?php
require_once (__DIR__ . '/../db_handler/DB.php');
session_start();

$db = new Database("../database/database.db");
$userId = $_SESSION['userId'];

$messages = $db->getMessagesUser($userId);

echo json_encode($messages);
?>
