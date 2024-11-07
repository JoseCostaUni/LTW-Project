<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>homepage</title>

        <link href="../css/homepage.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,200..900;1,200..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
            rel="stylesheet">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://cdn.jsdelivr.net/npm/dompurify@2.3.3/dist/purify.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/xss/dist/xss.min.js"></script>
        <script src="js/homepage.js"></script>

    </head>

    <body>
        <?php
        include 'templates/header.php';
        ?>

        <input type="hidden" name="csrf" id="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">

        <span class="search_table">
            <input type="text" placeholder="What are you searching for?" class="search_bar"> </input>
            <select class="category_dropdown">
                <option value="">Locations</option>
                <option value="Aveiro">Aveiro</option>
                <option value="Beja">Beja</option>
                <option value="Braga">Braga</option>
                <option value="Bragança">Bragança</option>
                <option value="Castelo Branco">Castelo Branco</option>
                <option value="Coimbra">Coimbra</option>
                <option value="Évora">Évora</option>
                <option value="Faro">Faro</option>
                <option value="Guarda">Guarda</option>
                <option value="Leiria">Leiria</option>
                <option value="Lisboa">Lisboa</option>
                <option value="Portalegre">Portalegre</option>
                <option value="Porto">Porto</option>
                <option value="Santarém">Santarém</option>
                <option value="Setúbal">Setúbal</option>
                <option value="Viana do Castelo">Viana do Castelo</option>
                <option value="Vila Real">Vila Real</option>
                <option value="Viseu">Viseu</option>
            </select>


            <button class="search_button">
                Search
                <img src="assets/search-interface-symbol.png" alt="search-icon" class="search_icon">
            </button>
        </span>

        <span class="Categorias_Principais">
            Principal Categories
        </span>

        <div class="Categories">
            <div class="image-container">
                <img src="assets/carro-removebg-preview.png" alt="car">
                <span>Vehicles</span>
            </div>
            <div class="image-container">
                <img src="assets/bola-removebg-preview.png" alt="ball">
                <span>Sports</span>
            </div>
            <div class="image-container">
                <img src="assets/chair-removebg-preview.png" alt="chair">
                <span>Furniture</span>
            </div>
            <div class="image-container">
                <img src="assets/tshirt.png" alt="tshirt">
                <span>Clothes</span>
            </div>
            <div class="image-container">
                <img src="assets/mobilePhone-removebg-preview.png" alt="mobile phone">
                <span>Mobile Phones</span>
            </div>

            <div class="image-container">
                <img src="assets/computer-removebg-preview.png" alt="computer">
                <span>Technology</span>
            </div>

            <div class="image-container">
                <img src="assets/guitar-removebg-preview.png" alt="guitar">
                <span>Music</span>
            </div>

        </div>

        <span class="Buy_From_Brand">
            Buy from Brand
        </span>

        <?php
        require_once '../db_handler/DB.php';

        $db = new Database("../database/database.db");

        $allItems = $db->getItems("../database/database.db");
        $map = array();

        foreach ($allItems as $item) {
            $map[$item->getBrand()] = 0;
        }

        foreach ($allItems as $item) {
            $map[$item->getBrand()] += 1;
        }
        
        arsort($map);

        $topBrands = array_slice($map, 0, 15    );

        echo "<div class='brands'>";

        foreach ($topBrands as $brand => $value) {
            echo "
                <button>
                    $brand
                </button> ";
        }

        echo "</div>";
    ?>

        <span class="Feed">
            Posts
        </span>

        <div class="Items">

            <?php
require_once '../db_handler/DB.php';

$db = new Database("../database/database.db");

$randomItems = $db->getXRandItems(21);

    $userId = -1;

    if (isset($_SESSION['userId'])) {
        $userId = $_SESSION['userId'];
    }


foreach ($randomItems as $item) {

    if ($item->getUserId() == $userId) {
        continue;
    }
    
    $name = $item->getName();
    $price = $item->getPrice();
    $brand = $item->getBrand();

    ?>

            <div class='item'>
                <?php
            $itemImagePath = "../assets/items/{$item->getId()}-1.png";
            $errorImagePath = "../assets/items/error.png";

            if (file_exists($itemImagePath)) {
                $imageSrc = $itemImagePath;
            } else {
                $imageSrc = $errorImagePath;
            }
        ?>
                <a href='itempage.php?item=<?=$item->getId() ?>'>
                    <img src="<?= $imageSrc ?>" alt='<?= $item->getName() ?>'>
                </a>
                <h3><?= $item->getName() ?></h3>
                <p>Price: <?= $item->getPrice() ?></p>
                <p>Brand: <?= $item->getBrand() ?></p>
                <input type="hidden" name="itemId" value="<?= $item->getId() ?>">

                <button class="wishlist_button wishilist_send"><i class="fa-regular fa-heart"
                        data-item-id="<?= $item->getId(1) ?>"></i></button>
            </div>

            <?php } ?>

        </div>

        <div class="search-items"> </div>

        <?php
        include 'templates/footer.php';
    ?>
    </body>

</html>