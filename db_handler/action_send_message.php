<?php
session_start();

if ($_SESSION['csrf'] !== $_POST['csrf_token']) {
	exit();
}

if (isset($_POST['message'])) {
    require_once (__DIR__ . '/DB.php');

    $message = $_POST['message'];

    $currentUser = $_SESSION['userId'];

    $receiverUser = $_POST['receiverId'];

    $itemId = $_POST['itemId'];

    $db = new Database("../database/database.db");

    if($receiverUser == $currentUser){
        $item = $db->getItemById($itemId);
        $receiverUser = $item->getUserId();
    }

    $db->saveMessagesDb($currentUser, $receiverUser, $itemId, $message);

    echo $message;
}
?>
