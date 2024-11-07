<?php
    require_once '../../db_handler/DB.php';

    $database = new Database('../../database/database.db');
    $conditions = $database->getConditions();

    $conditionsArray = [];
    foreach ($conditions as $subCategory) {
        $conditionsArray[] = [
            $subCategory->getId(),
            $subCategory->getName(),
        ];
    }

    $jsonItems = json_encode($conditionsArray);

    echo $jsonItems;
?>
