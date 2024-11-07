<?php
    require_once '../../db_handler/DB.php';

    $database = new Database('../../database/database.db');
    $sizes = $database->getSizes();

    $sizesArray = [];
    foreach ($sizes as $subCategory) {
        $sizesArray[] = [
            $subCategory->getId(),
            $subCategory->getName(),
        ];
    }

    $jsonItems = json_encode($sizesArray);

    echo $jsonItems;
?>
