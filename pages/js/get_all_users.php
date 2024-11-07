<?php
    require_once '../../db_handler/DB.php';

    $database = new Database('../../database/database.db');
    $users = $database->getAllUsers();

    $usersArray = [];
    foreach ($users as $user) {
        $usersArray[] = [
            $user->getId(),
            $user->getUsername(),
            $user->getEmail(),
            $user->getFirstName(),
            $user->getLastName(), 
            $user->getAddress(), 
            $user->getPhoneNumber(),
        ];
    }

    $jsonItems = json_encode($usersArray);

    echo $jsonItems;    
?>

