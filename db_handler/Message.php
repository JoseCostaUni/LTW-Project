<?php

require_once 'Users.php';

class Message {
    public $messageId;
    public $sender;
    public $itemId;
    public $receiver;
    public $text;
    public $timestamp;

    public function __construct($messageId, $sender, $receiver,$itemId, $text, $timestamp) {
        $this->messageId = $messageId;
        $this->sender = $sender;
        $this->itemId = $itemId;
        $this->receiver = $receiver;
        $this->text = $text;
        $this->timestamp = $timestamp;
    }

    public function displayDetails() {
        echo "Message Id: " . $this->messageId . "<br>";
        echo "Sender: " . $this->sender . "<br>";
        echo "Receiver: " . $this->receiver . "<br>";
        echo "Item Id: " . $this->itemId . "<br>";
        echo "Text: " . $this->text . "<br>";
        echo "Timestamp: " . $this->timestamp . "<br>";
    }

    public function getMessageId() : int {
        return $this->messageId;
    }
    
    public function getItemId() : Item {
        return $this->itemId;
    }

    public function getContent() : string {
        return $this->text;
    }

    public function getReceiver() : User {
        return $this->receiver;
    }

    public function getSender() : User {
        return $this->sender;
    }

    public function getTimestamp(): string {
        return $this->timestamp;
    }

    public function printTimestamp() : string {
        $currentTime = new DateTime();
        $messageTime = new DateTime($this->timestamp);
    
        $interval = $currentTime->diff($messageTime);
    
        if ($interval->days == 0) {
            $hoursPassed = $interval->h + ($interval->days * 24);
            return $hoursPassed . ' hours ago';
        } else {
            return $interval->days . ' days ago';
        }
    }
    
}

?>
