<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminPage</title>

    <link href="../css/adminPage.css" rel="stylesheet">
    <link rel="shortcut icon" href="#">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,200..900;1,200..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/dompurify@2.3.3/dist/purify.min.js"></script>
    <script src="js/adminpage.js"></script>
</head>
<body>
    <?php
        include 'templates/header.php';
    ?>

    <input type="hidden" name="csrf" id="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">
    
    <div class="adminPage">
        <h1>Página de Administrador</h1>

        <h3>Selecione a opção que deseja visualizar</h3>

        <div class="adminOptions">
            <div class="option" id="users">
                <button>
                    <i class="fa fa-users"></i>
                    <p>Utilizadores</p>
                </button>
            </div>

            <div class="option" id="items">
                <button>
                <i class="fa fa-shopping-cart"></i>
                <p>Itens</p>
                </button>
            </div>

            <div class="option" id="categories">
                <button>
                <i class="fa fa-list
                "></i>
                <p>Categorias</p>
                </button>
            </div>     
        </div>


        <div id="usersContent" class="content">

            <div class="optionsText">
                <h4>Opção dos users: </h4>
            </div>
            <section class="search_table">

                <?php
                require_once '../db_handler/DB.php';

                $db = new Database('../database/database.db');

                $users = $db->getAllUsers();
                ?>


                <span class="search_table">

                    <div class="search-box">
                        <div class="row">
                            <input type="text" placeholder="O que Procuras?" class="search_bar"> </input>
                        </div>

                        <div class="result-box" id = "result-box-users">
                            <ul class="result">

                            </ul>
                        </div>
                    </div>


                    <button class="search_button">
                        Pesquisar
                        <img src="assets/search-interface-symbol.png" alt="search-icon" class="search_icon">
                    </button>
                </span>
            </section>
        </div>

        <div id="itemsContent" class="content" style="display: none;">
            <div class="optionsText">
                <h4 class = "optionsTextText">Opção dos items</h4>
            </div>

            <section class="search_table">

                <?php
                require_once '../db_handler/DB.php';

                $db = new Database('../database/database.db');

                $users = $db->getItems();
                ?>


                <span class="search_table">

                    <div class="search-box">
                        <div class="row">
                            <input type="text" placeholder="O que Procuras?" class="search_bar" id = "search-bar-item"> </input>
                        </div>

                        <div class="result-box" id = "result-box-items">
                            <ul class="result">

                            </ul>
                        </div>
                    </div>


                    <button class="search_button" id = "search-bar-item-button">
                        Pesquisar
                        <img src="assets/search-interface-symbol.png" alt="search-icon" class="search_icon">
                    </button>
                </span>
            </section>
        </div>

        <div id="categoriesContent" class="content" style="display: none;">
            <div class="optionsText">
                <h4>Opção das categorias</h4>
            </div>
            <div class = "CategoriesSections">
            <section class = "showAllCateogiries">
                <button>
                    <h4>Show all Categories</h4>
                    <i class="fa fa-list"></i>
                    
                </button>
            </section>

            <section class = "showAllSubCateogiries">
                <button>
                    <h4>Show all Sub Categories</h4>
                    <i class="fa fa-list"></i>
                </button>
            </section>

            <section class = "showAllSizes">
                <button>
                    <h4>Show all Sizes</h4>
                    <i class="fa fa-list"></i>
                </button>
            </section>

            <section class = "showAllConditions">
                <button>
                    <h4>Show all Conditions</h4>
                    <i class="fa fa-list"></i>
                </button>
            </section>

            <section class = "AddCategory">
                <button>
                    <h4>Add Category</h4>
                    <i class="fa fa-plus" ></i>
                </button>
            </section>

            <section class = "AddSubCategory">
                <button>
                    <h4>Add Sub Category</h4>
                    <i class="fa fa-plus" ></i>
                </button>
            </section>

            <section class = "AddSize">
                <button>
                    <h4>Add Size</h4>
                    <i class="fa fa-plus" ></i>
                </button>
            </section>

            <section class = "AddCondition">
                <button>
                    <h4>Add Condition</h4>
                    <i class="fa fa-plus" ></i>
                </button>
            </section>

            </div>
        </div>

    <div class = "options-icons">
        <button id="delete_button"><i class="fas fa-trash trash-icon" ></i></button>
        <button id="arrow_up"><i class="fas fa-arrow-up up-arrow-icon" ></i></button>
        <button id="arrow_down"><i class="fas fa-arrow-down down-arrow-icon"></i></button>
    </div>

    <div class = "search-items"></div>

    <div class = "search-users"></div>

    <div class = "miscelaneousStuff"></div>

    <?php
        include 'templates/footer.php';
    ?>

</body>
</html>