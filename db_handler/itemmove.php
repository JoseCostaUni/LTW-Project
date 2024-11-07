<?php
declare(strict_types=1);
require_once(__DIR__ . '/connection.php');
require_once(__DIR__ . '/Wishlist.php');

function add_item_to_wishlist($dbh, WishlistItem $wishlistItem): void {
    
        $query = $dbh->prepare('INSERT INTO Wishlist (UserId, ItemId) VALUES (?, ?);');
        $query->execute([$wishlistItem->getUserId(), $wishlistItem->getItemId()]);
    
}


function add_item_shopping_cart($dbh,ShoppingCartItem $shoppingCartItem): void
{
        $query = $dbh->prepare('INSERT INTO ShoppingCart (UserId, ItemId) VALUES (?, ?);');
        $query->execute([$shoppingCartItem->getUserId(), $shoppingCartItem->getItemId()]);
}

function get_wishlist_items_ids($dbh, $userId) {
        $stmt = $dbh->prepare("SELECT itemId FROM wishlist WHERE userId = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $wishlistItems = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $wishlistItems[] = $row['ItemId'];
        }
        return $wishlistItems;
}

function get_cart_items_ids($dbh, $userId)
{
        $stmt = $dbh->prepare("SELECT ItemId FROM ShoppingCart WHERE userId = :userId");
        $stmt->bindParam(":userId", $userId);
        $stmt->execute();
        $cartItems = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $cartItems[] = $row['ItemId'];
        }
        return $cartItems;
}

function remove_from_wishilist($dbh, WishlistItem $wishlistItem) : void {
        $query = $dbh->prepare('DELETE FROM Wishlist WHERE UserId = ? AND ItemID = ?');
        $query->execute([$wishlistItem->getUserId(), $wishlistItem->getItemId()]);
}

function remove_from_shoppingcart($dbh, ShoppingCartItem $shoppingCartItem) : void {
        $query = $dbh->prepare('DELETE FROM ShoppingCart WHERE UserId = ? AND ItemID = ?');
        $query->execute([$shoppingCartItem->getUserId(), $shoppingCartItem->getItemId()]);
}


function getItemFromShoppingCartUserId($dbh, $userId, $itemId) {
        $stmt = $dbh->prepare("SELECT * FROM ShoppingCart WHERE userId = :userId AND ItemId = :itemId");
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":itemId", $itemId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
}

?>