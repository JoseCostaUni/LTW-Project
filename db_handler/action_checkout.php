<?php

require_once 'DB.php';
require_once 'Item.php';

session_start();

if ($_SESSION['csrf'] !== $_POST['csrf_token']) {
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paymentMethod = $_POST["paymentMethod"];
    $shippingMethod = $_POST["shippingMethod"];
    $totalPrice = $_POST["totalPrice"];
    $jsonItemIds = $_POST["jsonItemIds"];
    $user = $_SESSION['userId'];

    $shoppingItemIds = json_decode($jsonItemIds);

    $db = new Database("../database/database.db");

    $db->AddOrderHistory($user, $totalPrice, $shippingMethod, $paymentMethod,);

    $orderId = $db->RetrieveLastOrderHistory();

    foreach ($shoppingItemIds as $itemId) {
        $db->AddOrderItem($orderId, $itemId);
        $db->UpdateItemNotAvailable($itemId);
        $db->deleteItemShoppingCart($itemId);
        $db->deleteItemWishlist($itemId);
        $db->deleteItemProposals($itemId);
    }   

} else {

    echo "Invalid request method";
}




?>