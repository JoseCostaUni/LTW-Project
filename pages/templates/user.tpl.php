<?php
declare(strict_types=1);
?>

<?php function register_login_form()
{?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../../css/loginsignuppage.css">
    <script src="https://cdn.jsdelivr.net/npm/validator/validator.min.js"></script>                
    <title>Register and Login page</title>
</head>

<body>

    <section class="container" id="container">
        <section class="form-container sign-up">
            <form action="../../db_handler/action_register.php" method="POST">
                <h1>Create Account</h1>
                <section class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>

                </section>
                <span>or Register with:</span>
                <input type="text" name= "firstname" placeholder="Name">
                <input type="text" name= "lastname" placeholder="Surname">
                <input type="username" name= "username" placeholder="Username">
                <input type="email" name= "email" placeholder="Email">
                <input type="password" name= "password" placeholder="Password">
                <input type="text" name= "address" placeholder="Adress">
                <input type="tel" name= "phonenumber" placeholder="Phone number">
                <button type = "submit">Sign Up</button>
            </form>
        </section>
        <section class="form-container sign-in">
            <form action="../../db_handler/action_login.php" method="POST">
                <h1>Sign In</h1>
                <section class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
   
                </section>
                <span>or Sign In with:</span>
                <input type="email" name= "email" placeholder="Email">
                <input type="password" name = "password" placeholder="Password">
                <a href="#">Forget Your Password?</a>
                <button type = "Submit">Sign In</button>
            </form>
        </section>
       
        <section class="toggle-container">
            <section class="toggle">
                <section class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </section>
                <section class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </section>
            </section>
        </section>
    </section>

    <script src="js/loginsignup.js"></script>
</body>

</html>

<?php } ?>
