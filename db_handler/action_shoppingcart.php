<?php
declare(strict_types=1);

session_start();

require_once(__DIR__ . '/connection.php');
require_once(__DIR__ . '/ShoppingCart.php');
require_once(__DIR__ . '/DB.php');
require_once(__DIR__ . '/itemmove.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['csrf']) || $_SESSION['csrf'] !== $_POST['csrf']) {
        header("Location: ../pages/homepage.php");
        exit();
    }
}

if (!isset($_SESSION['userId'])) {
    header("Location: ../pages/userReg.php");
    exit();
}

$userId = $_SESSION['userId'];
$itemId = $_POST['itemId'] ?? null; 
$db = new DB();
$dbh = $db->get_database_connection();    

$shoppingcartItem = new ShoppingCartItem(null, $userId, $itemId);

$cartItems = get_cart_items_ids($dbh, $userId);

if(!in_array($itemId, $cartItems)){
    add_item_shopping_cart($dbh, $shoppingcartItem);
}

echo json_encode(['shoppingcartitems' => $cartItems, 'message' => 'Sucesso']);

header("Location: ../pages/shopping.php");
?> 