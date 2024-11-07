<?php
declare(strict_types=1);

session_start();

if ($_SESSION['csrf'] !== $_POST['csrf_token']) {
    exit();
}

require_once(__DIR__ . '/connection.php');
require_once(__DIR__ . '/ShoppingCart.php');
require_once(__DIR__ . '/DB.php');
require_once(__DIR__ . '/itemmove.php');

if (!isset($_SESSION['userId'])) {
    header("Location: ../pages/userReg.php");
    exit();
}

$userId = $_SESSION['userId'];
$itemId = $_POST['itemId'] ?? null; 
$db = new DB();
$dbh = $db->get_database_connection();    

$shoppingcartItem = new ShoppingCartItem(null, $userId, $itemId);

add_item_shopping_cart($dbh, $shoppingcartItem);

$cartItems = get_cart_items_ids($dbh, $userId);

echo json_encode(['shoppingcartitems' => $cartItems, 'message' => 'Sucesso']);
?>
