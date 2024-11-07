
<?php

class OrderHistory {
    public $OrderId;
    public $UserId;
    public $OrderDate;
    public $TotalPrice;
    public $PaymentMethod;
    public $ShippingMethod;
    public $Status;

    public function __construct($OrderId, $UserId, $OrderDate, $TotalPrice, $PaymentMethod, $ShippingMethod , $Status) {
        $this->OrderId = $OrderId;
        $this->UserId = $UserId;
        $this->OrderDate = $OrderDate;
        $this->TotalPrice = $TotalPrice;
        $this->Status = $Status;
        $this->PaymentMethod = $PaymentMethod;
        $this->ShippingMethod = $ShippingMethod;
    }

    public function getOrderId() {
        return $this->OrderId;
    }

    public function getUserId() {
        return $this->UserId;
    }

    public function getOrderDate() {
        return $this->OrderDate;
    }

    public function getTotalPrice() {
        return $this->TotalPrice;
    }

    public function getStatus() {
        return $this->Status;
    }

    public function getPaymentMethod() {
        return $this->PaymentMethod;
    }

    public function getShippingMethod() {
        return $this->ShippingMethod;
    }

    public function setOrderId($OrderId) {
        $this->OrderId = $OrderId;
    }

    public function setUserId($UserId) {
        $this->UserId = $UserId;
    }

    public function setOrderDate($OrderDate) {
        $this->OrderDate = $OrderDate;
    }

    public function setTotalPrice($TotalPrice) {
        $this->TotalPrice = $TotalPrice;
    }

    public function setStatus($Status) {
        $this->Status = $Status;
    }

    public function setPaymentMethod($PaymentMethod) {
        $this->PaymentMethod = $PaymentMethod;
    }

    public function setShippingMethod($ShippingMethod) {
        $this->ShippingMethod = $ShippingMethod;
    }


}

?>