    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile page</title>
        <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,200..900;1,200..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/profile.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
        <script src="js/profile_items.js"></script>
    </head>
    <body>
        <?php
            include 'templates/header.php';
        ?>

        <input type="hidden" name="csrf" id="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">
        
        <?php
            require_once (__DIR__ . '/../db_handler/DB.php');
            session_start();

            $db = new Database("../database/database.db");

            $userId = $_SESSION['userId'];

            $user = $db->getUserById($userId);

            $Reviews = $db->getReviewByReviewedUserId($userId);

            $reviewsCount = count($Reviews);

            $itemsAlreadySold = $db->GetItemsAlreadySold($userId);;
 
            $itemsAlreadySoldCount = count($itemsAlreadySold);

            if($reviewsCount == 0){
                $average = 0;
            }else{
                $average = number_format(array_reduce($Reviews, function ($carry, $review) {return $carry + $review->getRating();}, 0) / $reviewsCount,2);
            }

            if ($user) {
                echo "<section class='profile_info'>
                    <img src='../assets/users/{$user->getId()}.png' alt='{$user->getFirstName()} {$user->getLastName()}'>
                    <div class='user_details'>
                        <ul>
                            <li>{$user->getFirstName()} {$user->getLastName()}</li>
                            <li>{$user->getUsername()}</li>
                            <li>{$average} stars</li>
                            <li>{$reviewsCount} reviews</li>
                        </ul>
                        <ul class= 'About'>
                            <li>About:</li>
                            <li><img src='assets/profile/location.png' alt='location icon'> {$user->getAddress()}</li>
                            <li><img src='assets/profile/product.png' alt='product icon'> Items sold: {$itemsAlreadySoldCount}</li>
                        </ul>
                    </div>
                <div class='buttons'>    
                    <button class='edit_profile' id='edit_profile'><img src='assets/profile/editpencil.png' alt='pencil'> Edit Profile</button>
                    <button class='log_out' id='log_out'><i class='fa-solid fa-right-from-bracket'></i>Log out</button>
                </div>
                </section>";
            } else {
                echo "User not found.";
            }
        ?>

        <section class="profile_option">
            <ul>
                <li>
                    <a id="listings-link">Listings</a>        
                </li>
                <li>
                    <a id="ratings-link">Reviews</a>
                </li>
                <li>
                    <a id="items-sold">Items Sold</a>
                </li>
                <li>
                    <a id="purchases-link">Purchases</a>
                </li>
            </ul>
        </section>
        <div class="blue-line"></div>
        <span id="item-count">
         <?php
             require_once '../db_handler/DB.php';
     
             $db = new Database("../database/database.db");
         
             $Items = $db->getItemByUserId($userId);
 
             $ItemCount = count($Items);
 
             echo "<h3>Total items in active listing: $ItemCount</h3>";
         ?>
        </span>
        <div class = "Items" id="items-section">
         <?php
         require_once '../db_handler/DB.php';
     
         $db = new Database("../database/database.db");
         
         $Items = $db->getItemByUserId($userId);

         foreach ($Items as $item) {
             $id = $item->getId();
             $priceproposal = $db->getPriceProposalByUserId($id);

             $name = $item->getName();
             $price = $item->getPrice();
             $photo = "../../assets/items/{$item->getId()}-1.png";
             $brand = $item->getBrand();
             if($priceproposal != null){
                $proposalPrice = $priceproposal->getPrice();
             }
             
             if($photo == null)
                 $photo = "assets/error.png";
         
             echo "<span class='item'>
                     <img src='$photo' alt='$name' >
                     <h3 >$name</h3>
                     <p>Price: $price</p>
                     <p>Brand: $brand</p>";  
            if ($priceproposal != null) {
                echo "<p>Price Proposal: $proposalPrice</p>
                              <button id='$id' class='accept-proposal' data-item-id='$id'>Yes</button>
                              <button class='reject-proposal' data-item-id='$id'>No</button>";
            }
            echo "</span>";          
        }
         ?>
        </div>

        <nav id="reviews-count">
        <?php
             require_once '../db_handler/DB.php';
     
             $db = new Database("../database/database.db");
         
             $Reviews = $db->getReviewByReviewedUserId($userId);
 
             $reviewsCount = count($Reviews);
 
             echo "<h3>Total reviews: $reviewsCount </h3>";
        ?>
        </nav>

        <nav class = "Reviews" id="reviews-section">
         <?php
         require_once '../db_handler/DB.php';
     
         $db = new Database("../database/database.db");
         
         $Reviews = $db->getReviewByReviewedUserId($userId);
         
         foreach ($Reviews as $review) {

            $rating = $review->getRating();
            $date = $review->getReviewDate();
            $author = $review->getAuthor()->getUsername();
            $comment = $review->getComment();
            $photo = null;
            $reviewDate = $review->getReviewDate();


            if($photo == null)
                 $photo = "assets/error.png";
             else
                 $photo = "data:image/jpeg;base64," . base64_encode($photo);

         
             echo "<span class='review'>
                        <img src='$photo' alt='$author'>
                        <h3>$author</h3>
                        <h4>$reviewDate</h4>
                    <div class='rating'>
                        <span class='stars' style='--rating: $rating;'></span>
                        <span class='numeric-rating'>$rating</span>
                    </div> 
                     <p>$comment</p>
                 </span>";
             }
         ?>
        </nav>

        <nav id="items-sold-count">
         <?php
             require_once '../db_handler/DB.php';
     
             $db = new Database("../database/database.db");
         
             $itemsAlreadySold = $db->GetItemsAlreadySold($userId);;
 
             $itemsAlreadySoldCount = count($itemsAlreadySold);
 
             echo "<h3>Total Items Sold: $itemsAlreadySoldCount </h3>";
         ?>
        </nav>

        <nav class = "items-sold" id="items-sold-section">
         <?php
         require_once '../db_handler/DB.php';
     
         $db = new Database("../database/database.db");
         
         $itemsSold = $db->GetItemsAlreadySold($userId);

         foreach ($itemsSold as $item) {
            $id = $item->getId();

            $name = $item->getName();
            $price = $item->getPrice();
            $photo = "../../assets/items/{$item->getId()}-1.png";
            $brand = $item->getBrand();
            
            if($photo == null)
                $photo = "assets/error.png";
        
            echo "<span class='item'>
                    <img src='$photo' alt='$name' >
                    <h3 >$name</h3>
                    <p>Price: $price</p>
                    <p>Brand: $brand</p>";  
           echo "</span>";          
       }
         
         ?>
        </nav>

        <nav id="purchases-count">
         <?php
             require_once '../db_handler/DB.php';
     
             $db = new Database("../database/database.db");
         
             $purchases = $db->getOrderHistoryByUserId($userId);
 
             $purchasesCount = count($purchases);
 
             echo "<h3> Total Orders: $purchasesCount </h3>";
         ?>
        </nav>

        <nav class = "purchases" id="purchases-section">
         <?php
         require_once '../db_handler/DB.php';
     
         $db = new Database("../database/database.db");
         
         $orders = $db->getOrderHistoryByUserId($userId);

         foreach ($orders as $order) {
            $id = $order->getOrderId();
            $date = $order->getOrderDate();
            $total = $order->getTotalPrice();
            $paymentMethod = $order->getPaymentMethod();
            $shippingMethod = $order->getShippingMethod();
            
            echo "<span class='order'>
                    <div class='order_details'>
                        <h3>Order ID: $id</h3>
                        <p>Date: $date</p>
                        <p>Payment Method: $paymentMethod</p>
                        <p>Delivery Method: $shippingMethod</p>
                        <p>Total: $total</p>
                    </div>
                    <button class='view-order' data-order-id='$id'>View Shipping Form</button>";  
           echo "</span>";
                     
       }
         
         ?>
        </nav>


        <footer>
            <?php
                include 'templates/footer.php';
            ?>
        </footer>
    </body>
    </html>

