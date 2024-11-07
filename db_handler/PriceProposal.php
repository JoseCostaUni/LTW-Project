<?php
declare(strict_types=1);
class PriceProposal {
    // Properties (attributes)
    public $Id;
    public $Price;
    public $UserId;
    public $ItemId;
    public $Status;

    // Constructor with all attributes
    public function __construct($Id, $Price, $UserId, $ItemId, $Status) {
        $this->Id = $Id;
        $this->Price = $Price;
        $this->UserId = $UserId;
        $this->ItemId = $ItemId;
        $this->Status = $Status;
    }

    // Method to display price proposal details
    public function displayDetails() {
        echo "Id: " . $this->Id . "<br>";
        echo "Price: " . $this->Price . "<br>";
        echo "User Id: " . $this->UserId . "<br>";
        echo "Item Id: " . $this->ItemId . "<br>";
        echo "Status: " . $this->Status . "<br>";
    }

    public function getId(): int {
        return $this->Id;
    }

    public function getPrice(): float {
        return $this->Price;
    }

    public function getUserId(): int {
        return $this->UserId;
    }
    
    public function getItemId(): int {
        return $this->ItemId;
    }

    public function getStatus(): string {
        return $this->Status;
    }

    public function setStatus($status) {
        $this->Status = $status;
    }
}
?>
