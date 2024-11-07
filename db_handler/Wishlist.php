<?php
declare(strict_types=1);
class WishlistItem {
    public $WishlistId;
    public $UserId;
    public $ItemId;

    public function __construct($WishlistId, $UserId, $ItemId) {
        $this->WishlistId = $WishlistId;
        $this->UserId = $UserId;
        $this->ItemId = $ItemId;
    }

    public function getWishlistId()
    {
        return $this->WishlistId;
    }
    public function getUserId()
    {
        return $this->UserId;
    }
    public function getItemId()
    {
        return $this->ItemId;
    }
    
}



?>