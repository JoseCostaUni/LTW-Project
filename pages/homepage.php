<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale = 1.0">
    <title>Ecommerce</title> 
    <link rel="stylesheet" href="../css/homepage.css">
</head>
<body>
    <header>
        <nav id = 'menu'>
            <input type="checkbox" id='hamburguer'>
            <label class="hamburger" for="hamburger"></label>
        </nav>  
        <h1>Bem Vindo a loja</h1>
        <form action="resultado_da_pesquisa" method= "GET">
            <input type="text" name="pesquisa" placeholder="pesquisar">
            <button type="submit">search</button>
        </form>
        <nav>
            <ul>
                <li>catalogo</li>
                <li>Membro</li>
                <li>Help center</li>
            </ul>  
        </nav>
        <nav>
            <ul>
                <li><a href="#">homem</a></li>
                <li><a href="#">mulher</a></li>
                <li><a href="#">crianca</a></li>
                <li><a href="#">Desporto</a></li>
        </ul>
    </nav>
        <a href="loginpage.php" id="loginLink"><button id="openLogincard">Login</button></a>
    </header>
</body>
</html>
