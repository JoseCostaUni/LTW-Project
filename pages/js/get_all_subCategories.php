<?php
    require_once '../../db_handler/DB.php';

    $database = new Database('../../database/database.db');
    $subCategories = $database->getAllSubCategories();

    $subCategoriesArray = [];
    foreach ($subCategories as $subCategory) {
        $subCategoriesArray[] = [
            $subCategory->getSubCategoryId(),
            $subCategory->getName(),
        ];
    }

    $jsonItems = json_encode($subCategoriesArray);

    echo $jsonItems;
?>
