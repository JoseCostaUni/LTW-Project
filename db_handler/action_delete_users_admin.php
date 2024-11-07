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

    if( $myUser->getUserStatus() > $user->getUserStatus()){

        $db->deleteUserMessages($id);
        $db->deleteUserReviews($id);
        $db->deleteUserWishlist($id);
        $db->deleteUserShoppingCart($id);
        $db->deleteUserOrderHistory($id);
        $db->deleteUserItems($id);
        $db->deteleUserbyId($id);

        echo "success";

    }else{
        
        echo $myUser->getUserStatus();
        echo $user->getUserStatus();

        echo "You are not authorized to delete an admin";

        exit();

    }
?>