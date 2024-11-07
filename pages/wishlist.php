<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link
            href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,200..900;1,200..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
            rel="stylesheet">
        <link rel="stylesheet" href="../css/wishlist.css">
        <title>Wishlist</title>
    </head>

    <body>
        <?php
        include 'templates/header.php';
        ?>

        <input type="hidden" name="csrf" id="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">

        <h1>Wishlist</h1>
        <section id="banner-conatainer">

        </section>
        <section class="option">
            <h3>sort by</h3>
            <select name=" sorting" id="sorting">
                <option value="..."></option>
                <option value="recently added">recently added</option>
                <option value="alphabetical">Alphabetical</option>
                <option value="price-low-to-high">Price: Low to High</option>
                <option value="price-high-to-low">Price: High to Low</option>
            </select>
        </section>

        <?php
        require_once (__DIR__ . '/../db_handler/DB.php');
        require_once (__DIR__ . '/../db_handler/itemmove.php');

        session_start();
        $dB = new DB();
        $db = new Database("../database/database.db");

        $user = $_SESSION['userId'];
        $dbh = $dB->get_database_connection();

        $wishlistItemsIds = $db->getWishlistItems($user);
        $wishlistItemsDetails = array();
        foreach ($wishlistItemsIds as $itemId) {
            $itemDetails = $db->getItemById($itemId);
            if ($itemDetails) {
                $wishlistItemsDetails[] = $itemDetails;
            }
        }
        ?>
        
        <div class="items">
            <div class="wishlist-items">
                <?php foreach ($wishlistItemsDetails as $item): ?>
                    <div class="item">
                        <?php
                        $name = $item->getName();
                        $price = $item->getPrice();
                        $brand = $item->getBrand();

                        $itemImagePath = "../assets/items/{$item->getId()}-1.png";
                        $errorImagePath = "../assets/items/error.png";

                        if (file_exists($itemImagePath)) {
                            $imageSrc = $itemImagePath;
                        } else {
                            $imageSrc = $errorImagePath;
                        }
                        ?>
                        <a href="itempage.php?item=<?= $item->getId() ?>">
                            <img src="<?= $imageSrc ?>" alt="<?= $name ?>">
                        </a>
                        <div class="item_descriptors">
                            <h3><?= $name ?></h3>
                            <p>Price: <?= $price ?></p>
                            <p>Brand: <?= $brand ?></p>
                        </div>
                        <div class="item_buttons">
                            <input type="hidden" name="itemId" value="<?= $item->getId() ?>">
                            <button class="wishilist_send"><i class="fa-solid fa-heart"
                                    data-item-id="<?= $item->getId() ?>"></i></button>
                            <button class="cart_add"><i class="fa-solid fa-cart-shopping"
                                    data-item-id="<?= $item->getId() ?>"></i></button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        include 'templates/footer.php';
        ?>
        <script src="js/wishlist.js"></script>
    </body>

</html>