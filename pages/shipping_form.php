<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/shippingForm.css">
    <script src="js/shipping_form.js"></script>
    <title>Shipping Form</title>
</head>
<body>
<?php
    require_once '../db_handler/DB.php';
    if (isset($_GET['order'])) {
        $orderId = $_GET['order'];
        $db = new Database("../database/database.db");

        $order = $db->getOrderHistoryById($orderId);
        $user = $db->getUserById($order->getUserId());
        $items = $db->getOrderItemsByOrderId($orderId);

        if ($order) {
            ?>
            <div class="logo-container">
                <a href="../../pages/homepage.php">
                    <img src="../../assets/logo.png" alt="logo" class="logo">
                </a>
            </div>
            <form>
                <div class="order_details">
                    <p>Order ID: <?php echo htmlspecialchars($order->OrderId); ?></p>
                    <p>Name: <?php echo htmlspecialchars($user->getFirstName()); ?> <?php echo htmlspecialchars($user->getLastName()); ?></p>
                    <p>Order Date: <?php echo htmlspecialchars($order->OrderDate); ?></p>
                    <p>Tracking Number: <?php echo sha1($order->OrderDate + $order->OrderId); ?></p>
                    <p>Estimated Delivery Date: <?php echo generateEstimatedDateAfterOne($order->OrderDate); ?></p>
                    <p>Payment Method: <?php echo htmlspecialchars($order->PaymentMethod); ?></p>
                    <p>Shipping Method: <?php echo htmlspecialchars($order->ShippingMethod); ?></p>
                    <p>Delivery Address: <?php echo htmlspecialchars($user->getAddress()); ?></p>
                </div>
                <?php
                    foreach ($items as $item) {
                        $product = $db->getItemById($item->getItemId());
                        echo "<span class='item'>
                            <img src='../../assets/items/{$product->getId()}-1.png' alt='{$product->getName()}'>
                            <div class='item_details'>
                                <h3 >{$product->getName()}</h3>
                                <p>Price: {$product->getPrice()}</p>
                                <p>Brand: {$product->getBrand()}</p>
                            </div>
                            </span>";
                    }
                ?>
                <div class="total_price">
                    <p>Total Price: <?php echo htmlspecialchars($order->TotalPrice); ?>€</p>
                </div>
            </form>
            <?php

        } else {
            echo "Order not found.";
        }
    } else {
        echo "Order ID not provided.";
    }
    ?>
    
</body>
</html>

<?php
    function generateEstimatedDateAfterOne($date) {
        $estimatedDate = date('Y-m-d', strtotime('+15 day', strtotime($date)));
        return $estimatedDate;
    }
?>
