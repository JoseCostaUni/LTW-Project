<?php

require_once 'Users.php';

class Review {
    public $reviewId;
    public $rating;
    public $comment;
    public $author;
    public $userReviewed;
    public $reviewDate;

    public function __construct($reviewId, $rating, $comment, $author, $userReviewed, $reviewDate) {
        $this->reviewId = $reviewId;
        $this->rating = $rating;
        $this->comment = $comment;
        $this->author = $author;
        $this->userReviewed = $userReviewed;
        $this->reviewDate = $reviewDate;
    }

    public function displayDetails() {
        echo "Review Id: " . $this->reviewId . "<br>";
        echo "Rating: " . $this->rating . "<br>";
        echo "Comment: " . $this->comment . "<br>";
        echo "Author: " . $this->author . "<br>";
        echo "User Reviewed: " . $this->userReviewed . "<br>";
        echo "Review Date: " . $this->reviewDate . "<br>";
    }

    public function getReviewId() : int {
        return $this->reviewId;
    }

    public function getRating() : float {
        return $this->rating;
    }

    public function getComment() : string {
        return $this->comment;
    }

    public function getAuthor() : User {
        return $this->author;
    }

    public function getUserReviewed() : int {
        return $this->userReviewed;
    }

    public function getReviewDate() : string {
        return $this->reviewDate;
    }
}

?>
