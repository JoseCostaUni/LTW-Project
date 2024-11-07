THIS CODE WILL ONLY WORK IF THERE IS A DATABASE IN THE DIRECTORY ABOVE THIS ONE
TO BE RESOLVED IN THE FUTURE

It works as intended though, so I'm happy with it for now


<?php
// Include required files
/*
if (isset($_POST['execute'])) {
    require_once '../../db_handler/Item.php';
    require_once '../../db_handler/OrderHistory.php';
    require_once '../../db_handler/OrderItems.php';
    require_once '../../db_handler/ShoppingCart.php';
    require_once '../../db_handler/Users.php';
    require_once '../../db_handler/Wishlist.php';
    require_once '../../db_handler/DB.php';

    // Your predetermined function
    $db = new Database();

    $items = $db->getItems();
    $item = $items[0];

/*
    foreach ($items as $item) {
        // Do something with each item
        echo $item->getName() . '<br>';
    }
    

    function generate_item_listing($item) {
        // Initialize the listing HTML
        $listing = '<div class="item-listing">';
        
        // Display the item name
        $listing .= '<h2>' . $item->getName() . '</h2>';
    
        // Display the item price
        $listing .= '<p>Price: $' . number_format($item->getPrice(), 2) . '</p>';
    
        // Check if the item has a photo
        if ($item->getPhoto() !== null){
            // Display the item photo
            $listing .= '<img src="data:image/jpeg;base64,' . base64_encode($item->getPhoto()) . '" alt="Item Photo">';
        } else {
            // If no photo is available, display a placeholder
            $listing .= '<div class="placeholder-photo">No Photo Available</div>';
        }
    
        // Close the listing HTML
        $listing .= '</div>';
    
        return $listing;
    }

    $item_listing = generate_item_listing($item);


echo $item_listing;
}

*/
?>
