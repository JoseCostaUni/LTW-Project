<?php
session_start();

if($_POST['csrf_token'] !== $_SESSION['csrf']) {
    exit();
}

require_once 'DB.php';

$db = new Database("../database/database.db");

$allItems = $db->getItems();

if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../assets/items/';

    $arraySize = sizeof($allItems);
    
    $index = $_POST['index'];

    $filename = $arraySize . '-' . $index+1 . '.png';

    $targetPath = $uploadDir . $filename;

    if (move_uploaded_file($_FILES['item_image']['tmp_name'], $targetPath)) {
        echo $targetPath; 
    } else {
        http_response_code(500); 
        echo 'Error moving uploaded file';
    }
} else {
    http_response_code(400); 
    echo 'No file uploaded or an error occurred';
}
?>