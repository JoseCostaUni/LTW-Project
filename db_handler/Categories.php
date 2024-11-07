<?php

require_once 'DB.php';

class Category {
    private $id;
    private $name;

    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public static function getAllCategories() {
        $db = new Database("../database/database.db");
        $conn = $db->getConnection();
        $query = "SELECT * FROM categories";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        $categories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $category = new Category($row['id'], $row['name']);
            $categories[] = $category;
        }

        return $categories;
    }

    public static function insertCategory($name) {
        $db = new Database("../database/database.db");
        $conn = $db->getConnection();

        $query = "INSERT INTO categories (name) VALUES (?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$name]);

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}

?>