<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item page</title>
    <link href="../../css/itempage.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,200..900;1,200..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <script src="js/itempage.js"></script>
</head>
    <body>
        <?php
            include 'templates/header.php';
        ?>

        <div class="item-container">

            <?php
                require_once '../db_handler/DB.php';

                $db = new Database("../database/database.db");

                $itemId = $_GET['item'];

                $item = $db->getItemById($itemId);
            
                $name = $item->getName();
                $price = $item->getPrice();
                $brand = $item->getBrand();
                $user = $item->getUserId();
                $number_of_photos = $item->getNumberOfImages();
                
                $currentImageIndex = 1; 

                if ($numberOfImages !== null && $numberOfImages >= 1) {
                    if (isset($_GET['image'])) {
                        $currentImageIndex = max(1, min($_GET['image'], $numberOfImages));
                    }

                    $imageUrl = "../assets/items/{$item->getId()}-{$currentImageIndex}.png";
                }

                $user_details = $db->getUserById($user);
                $user_username = $user_details->getUsername();
                $user_phonenumber = $user_details->getPhoneNumber();
                $user_email = $user_details->getEmail();

            ?>
            

            
            <section class="image_section">
                <div class="main_image_container">
                    <img src="../assets/items/<?= $item->getId()?>-1.png" class="<?= $item->getId() . '-' . $item->getNumberOfImages() ?>" alt="<?= $name?>" id="item_image">
                </div>
                <div class = "preview_images_container">
                    <button id="prev-image">&larr;</button>
                    <div class="preview_images">
                        <?php
                            for ($i = 1; $i <= $item->getNumberOfImages(); $i++) {
                                echo '<img src="../assets/items/' . $item->getId() . '-' . $i . '.png" class="prev-image'. $i . '" alt="' . $name . '" id="preview_image">';
                            }
                        ?>
                    </div>
                    <button id="next-image">&rarr;</button>
                </div>
            </section>

            
            <section class = "description_and_rest_section">
                <div class = "item_details">
                    <p>Categoria: <?= $item->getCategoryId() ?></p>
                    <p>Marca: <?= $brand ?></p>
                    <p>Subcategoria: <?= $item->getSubcategory() ?></p>
                    <p>Disponível para entrega: <?= $item->isAvailableForDelivery() ? 'Sim' : 'Não' ?></p>
                </div>
                <p>Descrição</p>
                <p><?= $item->getDescription() ?></p>
            </section>

            <section class = "contact_user_section">
                <img src="../assets/users/<?= $user_details->getId() ?>.png" alt="<?= $user_username ?>" id="user_image">
                <p><?= $user_details->getUsername() ?></p>
                <p>last time online</p>
                <button>
                    Enviar Mensagem
                </button>
            </section>

            <section class = "title_price_section">
                <p>Nome: <?= $name ?></p>
                <p>Preço: <?= $price ?> EUR</p>

                <button>Propor Preço</button>

                <span id="user_phonenumber"><?= $user_phonenumber ?></span>
                <button id="reveal-num-button">Reveal Number</button>
            </section>

            <section class = "vendedor_section">
                <img src="../assets/users/<?= $user_details->getId() ?>.png" alt="<?= $user_username ?>" id="user_image">
                <p>Utilizador</p>
                <p><?= $user_username ?></p>
                <p>to be added : reviews</p>
            </section>

            <section class = "location_section">
                <?= $user_details->getAddress() ?>
            </section>              
        
        </div>
    <?php
        include 'templates/footer.php';
    ?>
    
    </body>
</html>