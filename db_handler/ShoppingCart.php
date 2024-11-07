<?php 
declare(strict_types=1);
class ShoppingCartItem {
    public $CartItemId;
    public $UserId;
    public $ItemId;

    public function __construct($CartItemId, $UserId, $ItemId) {
        $this->CartItemId = $CartItemId;
        $this->UserId = $UserId;
        $this->ItemId = $ItemId;
    }
    public function getCartItemId()
    {
        return $this->CartItemId;
    }

    public function getUserId(){
        return $this->UserId;
    }
    public function getItemId(){
        return $this->ItemId;
    }
}

?>