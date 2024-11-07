<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link
            href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,200..900;1,200..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
            rel="stylesheet">
        <link rel="stylesheet" href="../css/shopping.css">
        <script src="js/shopping_cart.js"></script>
        <title>Cart</title>
    </head>

    <body>
        <?php
        include 'templates/header.php';
        ?>

        <input type="hidden" name="csrf" id="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">

        <h1>Shopping Cart</h1>
        <section id="banner-conatainer">

        <?php
        require_once (__DIR__ . '/../db_handler/DB.php');
        require_once (__DIR__ . '/../db_handler/itemmove.php');

        $dB = new DB();
        $db = new Database("../database/database.db");

        $user = $_SESSION['userId'];
        $dbh = $dB->get_database_connection(); // Obtenha a conexão com o banco de dados aqui
        
        $ShoppingItemsIds = get_cart_items_ids($dbh, $user);

        // Recupere os detalhes dos itens da tabela de itens com base nos IDs da Shopping
        $ShoppingCartItemsDetails = array();
        foreach ($ShoppingItemsIds as $itemId) {
            $itemDetails = $db->getItemById($itemId);
            if ($itemDetails) {
                $ShoppingCartItemsDetails[] = $itemDetails;
            }
        }
        ?>

        <section class="cart_body">
            <div class="ShoppingCart-items">
                <?php foreach ($ShoppingCartItemsDetails as $item): ?>
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
                    <h3><?= $name ?></h3>
                    <p>Price: <?= $price ?>€</p>
                    <input type="hidden" name="itemId" value="<?= $item->getId() ?>">
                    <button class="Remove_cart" data-item-id="<?= $item->getId() ?>">Remove
                    </button>
                </div>
                <?php endforeach; ?>
            </div>
            

            <section class="checkout zone">
                <div class="summary">
                    <span>Summary</span>
                    <div class="line"></div>
                    <div class="item-count">
                        <span>Number of Items:</span>
                        <span class="item-count-value">0</span>
                    </div>
                    <div class="total-price">
                        <span>Total Price:</span>
                        <span class="total-item-price-value">0.00€</span>
                    </div>
                </div>
                <div class="shipping">
                    <span>Shipping:</span>
                    <select class="text-dropdown">
                        <option value="standard">Standard Shipping</option>
                        <option value="express">Express Shipping</option>
                        <option value="next-day">Next-Day Delivery</option>
                        <option value="international">International Shipping</option>
                    </select>
                </div>
                <div class="payment-method">
                    <span>Payment Method:</span>
                    <select class="text-dropdown">
                        <option value="credit-card">Credit Card</option>
                        <option value="paypal">PayPal</option>
                        <option value="apple-pay">Apple Pay</option>
                        <option value="mb-way">Mb Way</option>
                    </select>
                </div>
                <div class="total-price">
                    <span>Total Price:</span>
                    <span class="total-price-value">0.00€</span>
                </div>
                <button class="checkout-button">Checkout</button>
            </section>

            
        </section>
    </section>

        <?php
        include 'templates/footer.php';
        ?>
    </body>

</html>