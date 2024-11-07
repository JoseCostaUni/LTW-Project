<?php

require_once (__DIR__ . '/../db_handler/DB.php');
session_start();

if(isset($_SESSION['userId'])) {
    $senderId = (int) $_GET['senderId'];
    
    $userId = (int) $_SESSION['userId'];

    $itemId = (int) $_GET['itemId'];

    $db = new Database("../database/database.db");

    if($senderId == $userId){
        $item = $db->getItemById($itemId);
        $senderId = $item->getUserId();
    }

    $messages = $db->getMessagesSenderToUser($userId,$senderId,$itemId); // Vai buscar as mensagens mandadas pelo outro para o log-in user

    header('Content-Type: application/json');
    echo json_encode($messages);

} else {
    echo json_encode(['error' => 'userId parameter is missing']);
}
?>
