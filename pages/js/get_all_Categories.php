<?php
    require_once '../../db_handler/DB.php';

    $database = new Database('../../database/database.db');
    $categories = $database->getCategories();

    $categoriesArray = [];
    foreach ($categories as $categories) {
        $categoriesArray[] = [
            $categories->getId(),
            $categories->getName(),
        ];
    }

    $jsonItems = json_encode($categoriesArray);

    echo $jsonItems;
?>
