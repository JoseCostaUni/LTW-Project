<?php
declare(strict_types=1);
class User {
    // Properties (attributes)
    public $Id;
    public $Username;
    public $Email;
    public $PasswordHash;
    public $FirstName;
    public $LastName;
    public $status;
    public $Address;
    public $PhoneNumber;

    // Constructor with all attributes
    public function __construct($Id, $Username, $Email, $PasswordHash, $FirstName, $LastName, $status , $Address, $PhoneNumber) {
        $this->Id = $Id;
        $this->Username = $Username;
        $this->Email = $Email;
        $this->PasswordHash = $PasswordHash;
        $this->FirstName = $FirstName;
        $this->LastName = $LastName;
        $this->status = $status;
        $this->Address = $Address;
        $this->PhoneNumber = $PhoneNumber;
    }

    // Method to display user details
    public function displayDetails() {
        echo "Id: " . $this->Id . "<br>";
        echo "Username: " . $this->Username . "<br>";
        echo "Email: " . $this->Email . "<br>";
        echo "PasswordHash: " . $this->PasswordHash . "<br>";
        echo "First Name: " . $this->FirstName . "<br>";
        echo "Last Name: " . $this->LastName . "<br>";
        echo "Address: " . $this->Address . "<br>";
        echo "Phone Number: " . $this->PhoneNumber . "<br>";
    }

    public function getId(): int {
        return $this->Id;
    }

    public function getUsername(): string {
        return $this->Username;
    }

    public function getEmail(): string {
        return $this->Email;
    }
    
    public function getPasswordHash(): string {
        return $this->PasswordHash;
    }

    public function getFirstName(): string {
        return $this->FirstName;
    }

    public function getLastName(): string {
        return $this->LastName;
    }

    public function getAddress(): string {
        return $this->Address;
    }

    public function getPhoneNumber(): string {
        return $this->PhoneNumber;
    }

    public function getUserStatus() {
        return $this->status;
    }

    public function setUserStatus($status) {
        $this->status = $status;
    }
}
?>