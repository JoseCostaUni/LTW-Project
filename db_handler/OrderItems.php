
<?php

class OrderItem {
    public $OrderItemId;
    public $OrderId;
    public $ItemId;

    public function __construct($OrderItemId, $OrderId, $ItemId) {
        $this->OrderItemId = $OrderItemId;
        $this->OrderId = $OrderId;
        $this->ItemId = $ItemId;
    }

    public function getOrderItemId() {
        return $this->OrderItemId;
    }

    public function getOrderId() {
        return $this->OrderId;
    }

    public function getItemId() {
        return $this->ItemId;
    }

    public function setOrderItemId($OrderItemId) {
        $this->OrderItemId = $OrderItemId;
    }

    public function setOrderId($OrderId) {
        $this->OrderId = $OrderId;
    }

    public function setItemId($ItemId) {
        $this->ItemId = $ItemId;
    }
}


?>