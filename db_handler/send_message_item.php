<?php
session_start();

if ($_SESSION['csrf'] !== $_POST['csrf_token']) {
	exit();
}

if (isset($_POST['receiverId'])) {
    require_once (__DIR__ . '/DB.php');

    $currentUser = $_SESSION['userId'];

    $receiverUser = $_POST['receiverId'];

    $itemId = $_POST['itemId'];

    $message = "Hello, is this item still available?";

    $db = new Database("../database/database.db");

    $db->saveMessagesDb($currentUser, $receiverUser, $itemId, $message);
    
    echo "success";
}
?>