<?php 
    require_once '../db_handler/DB.php';
    require_once '../db_handler/Item.php';

    session_start();

    if ($_SESSION['csrf'] !== $_POST['csrf_token']) {
        exit();
    }

    $myId = $_SESSION['userId'];

    $db = new Database("../database/database.db");

    $id = $_POST['id'];

    $user = $db->getUserById($id);
    $myUser = $db->getUserById($myId);

    if($myUser->getUserStatus() > $user->getUserStatus()){

        $db->UpdateUserAdminStatus($user->getId(),$user->getUserStatus() + 1);

        $user->setUserStatus($user->getUserStatus() + 1);  
        
        echo "success";
        
    }else{
        
        echo "You are not authorized to elevate this user status admin";
        exit();
    }
?>