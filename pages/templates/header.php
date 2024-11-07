
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="js/header.js"></script>
    <link href="../../css/header.css" rel="stylesheet">
    <header>
        <?php
            session_start();
        ?>
      <nav class = "navbar">
        <div class = "navdiv"> 
            <div class = "logo"> 
                <a href="../../pages/homepage.php">
                        <img src="../../assets/logo.png" alt="logo" class="logo">
                </a>
            </div>
            <ul class = "headerNav">
                <li>
                    <i class="fa-solid fa-heart"></i>
                            <?php


                            if(isset($_SESSION['userId'])){

                                echo '<a href="../../pages/wishlist.php"> 
                                        Wishlist
                                    </a>';
                            }else{
                                echo '<a href="../../pages/userReg.php"> 
                                        Wishlist
                                    </a>';
                            
                            }

                        ?>
                </li>
                <li class = "profile-item">
                    <i class="fa-solid fa-user"></i>

                    <?php
                            if(isset($_SESSION['userId'])){

                                echo '<a href="../../pages/profile.php" class = "ProfileWord">Profile</a>
                                <ul class = "profile-options">';

                                require_once('../db_handler/DB.php');
                                $db = new Database("../database/database.db");
                                $user = $db->getUserById($_SESSION['userId']);

                                if($user->getUserStatus() == 1){
                                    echo '<li class = "profile-option"><a class = "option"  href="../../pages/AdminPage.php">
                                    <img src="../../assets/admin.png" class ="imageIcons" alt="">
                                        Página de Administrador</a></li>';
                                }

                                echo '<li class = "profile-option">
                                    <a class = "option" id="logout1" href="../../pages/userReg.php">
                                        <img src="../../assets/logout.png" class ="imageIcons" alt="">
                                        Entrar noutra conta
                                    </a>
                                </li>
                                <li class = "profile-option">
                                    <a class = "option" id="exit1" href="../../pages/homepage.php">
                                        <img src="../../assets/exit.png" class ="imageIcons" alt="">
                                        Sair
                                    </a>
                                </li>
                            </ul>';
                            }else{
                                echo '<a href="../../pages/userReg.php"> 
                                Profile
                                    </a>';
                            
                            }

                    ?>
                    
                </li>
                <li>
                    <i class="fa-solid fa-envelope"></i>
                    <?php


                            if(isset($_SESSION['userId'])){

                                echo '<a href="../../pages/messages.php"> 
                                Messages
                            </a>';
                            }else{
                                echo '<a href="../../pages/userReg.php"> 
                                        Messages
                                    </a>';
                            
                            }

                        ?>

                </li>
                <li>
                    <i class="fa-solid fa-shopping-cart"></i>   
                    <?php


                            if(isset($_SESSION['userId'])){

                                echo '<a href="../../pages/shopping.php"> 
                                Checkout
                            </a>';
                            }else{
                                echo '<a href="../../pages/userReg.php"> 
                                Checkout
                                    </a>';
                            
                            }

                        ?>
                </li>
                
                <?php


                    if(isset($_SESSION['userId'])){

                        echo '<a href="../../pages/itemCreationPage.php"> 
                                <button class = "anuncie">Announce Now</button>
                            </a>';
                    }else{
                        echo '<a href="../../pages/userReg.php"> 
                                <button class = "anuncie">Announce Now</button>
                            </a>';
                    
                    }

                ?>
            </ul>
        </div>
      </nav>
    </header>
