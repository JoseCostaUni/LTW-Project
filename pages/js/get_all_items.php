<?php
    require_once '../../db_handler/DB.php';

    $database = new Database('../../database/database.db');
    $items = $database->getItems();

    $itemsArray = [];
    foreach ($items as $item) {

        $categoryId = $item->getCategoryId();
        $category = $database->getCategoryNameById($categoryId);

        $sizeId = $item->getSize();
        $size = $database->getSizeNameById($sizeId);

        $conditionId = $item->getConditionId();
        $condition = $database->getConditionNameById($conditionId);

        $user = $database->getUserById($item->getUserId());
        $location = $user->getAddress();
        $addressParts = explode(',', $location);
        $district = trim(end($addressParts));
        $id = $user->getId();

        $itemsArray[] = [
            $item->getId(),
            $item->getName(),
            $item->getDescription(),
            $item->getBrand(),
            $category, 
            $size, 
            $item->getPrice(),
            $condition, 
            $item->getAvailable(),
            $item->isAvailableForDelivery(), 
            $item->getSubCategory(), 
            $item->getNumberOfImages(),
            $item->getHighlighted(),
            $location,
            $item->getUserId(),
        ];
    }

    $jsonItems = json_encode($itemsArray);

    echo $jsonItems;
?>
