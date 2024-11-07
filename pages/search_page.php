<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search_page</title>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,200..900;1,200..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link href="../css/search_page.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/dompurify@2.3.3/dist/purify.min.js"></script>
    <script src="js/search_bar.js"></script>

</head>
    <?php
        include 'templates/header.php';
    ?>
<body>
    <div class = "whole-page">
    <?php
        $searchValue = isset($_GET['search']) ? $_GET['search'] : '';
        $categoryValue = isset($_GET['category']) ? $_GET['category'] : '';

        function isSelected($value, $option) {
            return $value == $option ? 'selected' : '';
        }
    ?>

    <span class="search_table">
        <?php
            require_once '../db_handler/DB.php';

            $db = new Database('../database/database.db');

            $itemNames = $db->getItemsName();

            $itemNamesJson = json_encode($itemNames);
        ?>

        <script>
            var itemNames = <?php echo $itemNamesJson; ?>;
        </script>

        <span class="search_table">

            <div class = "search-box">
                <div class = "row">
                    <input type="text" placeholder="O que Procuras?" class="search_bar"> </input>
                </div>
                
                <div class = "result-box">
                    <ul class="result"> 
                    
                    </ul>
                </div>
            </div>
                 <select class="category_dropdown">
                    <option value="">Todas as Localizações</option>
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
                    Pesquisar
                    <img src="assets/search-interface-symbol.png" alt="search-icon" class = "search_icon">
                </button>
            </span>
    </span>
    
    <div class="filter_section">
        <span class="filter_text" id="filter_image">
            Apenas anúncios com imagens
            <button class="filter_button" id="image_filter">
                A
            </button>
        </span>
        <span class="filter_text" id="filter_delivery">
            Disponível para entrega
            <button class="filter_button" id="delivery_filter">
                A
            </button>
        </span>
       
        <span class="filter_keyword">
            Filtros
        </span>
        
        <div class = "line"></div>

        <select name="marca" id="marca_filter">
            <option value="" class="Marca" disabled>Marca</option>
            <option value="">Qualquer Uma</option>
                <?php
                    require_once '../db_handler/DB.php';

                    $db = new Database("../database/database.db");
    
                    $allItems = $db->getItems();
    
                    $brandCounts = array();
                    foreach ($allItems as $item) {
                        $brand = $item->getBrand();
                        if (!isset($brandCounts[$brand])) {
                            $brandCounts[$brand] = 0;
                        }
                        $brandCounts[$brand]++;
                    }
    
                    arsort($brandCounts);
    
                    $topBrands = array_keys($brandCounts);
                
                    foreach ($topBrands as $brand) {
                        echo "<option value=\"$brand\" class=\"Marca\">$brand</option>";
                    }
                    ?>
        </select>
        <select name="estado" id="estado_filter">
            <option value="" disabled>Estado</option>
            <option value="">Qualquer Um</option>
                <?php 
                require_once '../db_handler/DB.php';

                $db = new Database("../database/database.db");

                $allConditions = $db->getAllConditionsName();

                foreach ($allConditions as $condition) {
                    echo "<option value='{$condition}'>{$condition}</option>";
                }
            ?>
        </select>
        <span class = "price">Preço: </span>
        <input type="text" value="0" class="from">
        <input type="text" value="10000" class = "to">
        
        <div class = "line"></div>

            <select name="categorias" id="Categorias">
                <option value="" disabled>Categoria</option>
                <option value="">Qualquer Uma</option>
                <?php 
                require_once '../db_handler/DB.php';

                $db = new Database("../database/database.db");

                $allConditions = $db->getAllCategoriesName();

                foreach ($allConditions as $condition) {
                    echo "<option value='{$condition}'>{$condition}</option>";
                }
                ?>
            </select>

            <select name="subCategorias" id="subCategorias">

                <option value="" disabled>SubCategoria</option>
                <option value="">Qualquer Uma</option>
                <?php 
                require_once '../db_handler/DB.php';

                $db = new Database("../database/database.db");

                $allConditions = $db->getAllSubCategoryName();

                foreach ($allConditions as $condition) {
                    echo "<option value='{$condition}'>{$condition}</option>";
                }
                ?>
            </select>

            <select name="Tamanhos" id="Tamanhos">

                <option value="" disabled>Tamanho</option>
                <option value="">Qualquer Um</option>
                <?php 
                require_once '../db_handler/DB.php';

                $db = new Database("../database/database.db");

                $allConditions = $db->getAllSizesNames();

                foreach ($allConditions as $condition) {
                    echo "<option value='{$condition}'>{$condition}</option>";
                }
                ?>
            </select>

            <select name="sort" id="sort_filter">
                <option value="">Ordenar por</option>
                <option value="price_asc">Preço (menor para maior)</option>
                <option value="price_desc">Preço (maior para menor)</option>
            </select>
                

        <div class = "current_filters" >
            
        </div>
    
        <div class = "line"></div>
    </div>

    
    <div class = "search-items"></div>

    </div>

    <?php
        include 'templates/footer.php';
    ?>
</body>
</html>
