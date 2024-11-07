<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ItemCreationPage</title>

    <link href="../../css/itemCreation.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,200..900;1,200..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.4/purify.min.js"></script>
    <script src="js/itemCreation.js"></script>
    <link rel="shortcut icon" href="#">
    
</head>

<body>  
    <?php
        include 'templates/header.php'; 

        require_once '../db_handler/DB.php';

        $db = new Database("../database/database.db");

        $allCategories = $db->getAllCategoriesName();   
        $allsubCategories = $db->getAllSubCategoriesNames();
    ?>

    <input type="hidden" name="csrf" id="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">
    

    <p class="publish">Publish Item</p>
    <div class="ItemCreation">

    <section class="Item-Title-And-Categories">
        <p class="title">First, introduce a title*</p>
        <p class="box_title">Try to be as descriptive as possible.</p>
        <input type="text" class="Item-Title">
        
        <div class = "words-details">
            <p>Introduce atleast 1 character</p>
            <p class = "word-count">0/50 letters</p>
        </div>

        <div class="category-container">
            <p class="Category_choice">Choose a Category</p>
            <input type="text" placeholder="Choose a Category" class="search_category">
            <div class="suggestions">
                <?php
                foreach ($allCategories as $category ) {
                    echo "<div class='category-option' value='$category'>$category</div>";
                }
                ?>
            </div>
        </div>

        <p class="Sub_Category_choice">Choose a Sub-Category</p>
        <input type="text" placeholder="Choose a Sub-Category" class="sub_search_category">
        <div class="sub_suggestions">
            <?php

            foreach ($allsubCategories as $category) {
                echo "<div class='category-option' value='$category'>$category</div>";
            }
            ?>
        </div>
    </section>

        <section class="Item-Images">
            <p class="images">Images</p>
            <p class="images_text">The first image is the main photo of your announcement. You can insert more 15</p>
            <?php for ($i = 1; $i <= 15; $i++): ?>
                <form class = "form" id="myForm<?= $i ?>" method=POST enctype=multipart/form-data>
                    <input type="hidden" name="form_index" value="<?= $i ?>">
                    <input class="image_inputer" type="file" id="image<?= $i ?>" name="image<?= $i ?>" accept="image/*">
                    <label id="image_icon<?= $i ?>" class="image_icon" for="image<?= $i ?>">
                        <img src="../assets/camera.png" alt="Camera Icon" id="selected_image<?= $i ?>" class="selected_image<?= $i ?>">
                    </label><br>
                </form>
            <?php endfor; ?>
        </section>

        <section class="Item-Description">
            <p class = "item-description">Introduce a good description for your item!<span>*</span></p>
            <textarea class="description-text" placeholder="Introduce atleast 10 characters and no more than 1000"></textarea>
            <div class="word-details">
                <p class = "min_words">Introduce atleast 10 words</p>
                <p class="word-counter">0/200 words</p>
            </div>
        </section>


        <section class="Item-Price-Trade">
            <p class="Preço">Price (EUR) :</p>
            <input type="number" class="Preço_" min="0">
        </section>



        <section class="Additional-Info">
            <?php
                require_once '../db_handler/DB.php';

                $db = new Database("../database/database.db");

                $allSizes = $db->getSizes();
                $allModels = $db->getConditions();


            ?>

            <p class = "size">Size</p>
            <input type="text" class="Tamanho">
            <ul class="sizes">
                <?php 
                    foreach ($allSizes as $size) {
                        echo "<li class='size_list' value='{$size->getId()}'>{$size->getName()}</li>";
                    }
                ?>
            </ul>

            <p id = "brand">Brand*</p>
            <input type="text" class="Marca">

            <p class = "condition" >Condition*</p>
            <input type="text" class="Estado">
            <ul class = "conditions">
                <?php 
                    foreach ($allModels as $model) {
                        echo "<li class='condition_list' value='{$model->getId()}'>{$model->getName()}</li>";
                    }
                ?>
            </ul>
        </section>

        <section >
            <div class ="pre_visualizar_publicar_section">
                <button class ="Publicar">Publicar anúncio</button>
            </div>
        </section>

        </div>
        <?php
            include 'templates/footer.php';
        ?>

</body>
</html>
