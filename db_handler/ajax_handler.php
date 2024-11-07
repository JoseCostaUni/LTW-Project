<?php
    require_once 'DB.php';

    if(isset($_POST['action'])) {
        $action = $_POST['action'];


        $db = new Database("../database/database.db");

        switch($action) {
            case 'getItemsName':
                $itemNames = $db->getItemsName();
                echo json_encode($itemNames);
                break;
            case 'otherAction':
                echo json_encode(['error' => 'Not implemented']);
                break;
            default:
                echo json_encode(['error' => 'Invalid action']);
        }
    } else {
        echo json_encode(['error' => 'No action provided']);
    }
?>
