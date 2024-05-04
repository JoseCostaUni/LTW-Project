<?php
declare (strict_types= 1);

session_start();

require_once(__DIR__ . '/connection.php');
require_once(__DIR__ . '/ShoppingCart.php');
require_once(__DIR__ . '/DB.php');
require_once(__DIR__ . '/itemmove.php');

if (!isset($_SESSION['userId'])) {
    header("Location: ../pages/userReg.php");
    exit();
}

$userId = $_SESSION["userId"];

$itemId = $_POST["itemId"] ?? null;

$db = new DB();

$dbh = $db->get_database_connection();

$wishlistItem = new WishlistItem(null, $itemId, $userId);
?>