<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>

    <link href="../css/editprofile.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,200..900;1,200..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="js/editprofile.js"></script>
    <link rel="shortcut icon" href="#">
</head>
<body>
    <?php
        include 'templates/header.php';
    ?>

    <?php 
        require_once (__DIR__ . '/../db_handler/DB.php');
        session_start();
        $db = new Database("../database/database.db");
        $user = $db->getUserById($_SESSION['userId']);
        $current_first_name = $user->getFirstName();
        $current_last_name = $user->getLastName();
        $current_username = $user->getUsername();
        $current_email = $user->getEmail();
        $current_address = $user->getAddress();
        $current_phone_number = $user->getPhoneNumber();

    ?>
    
    <div class="edit-profile-container">
        <h2>Edit Profile</h2>
        <form action="../../db_handler/update_user_details.php" method="POST" enctype="multipart/form-data">

            <img src="../../assets/users/<?php echo $_SESSION['userId']; ?>.png" id="profile-image">

            <label for="first-name">First Name:</label>
            <input type="text" id="first-name" value="<?php echo $current_first_name; ?>" name="first_name" required>

            <label for="last-name">Last Name:</label>
            <input type="text" id="last-name"value="<?php echo $current_last_name; ?>" name="last_name" required>
            
            <label for="username">Username:</label>
            <input type="text" id="username"value="<?php echo $current_username; ?>" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            
            <label for="email">Email:</label>
            <input type="email" id="email"value="<?php echo $current_email; ?>" name="email" required>

            <label for="address">Address:</label>
            <input type="text" id="address"value="<?php echo $current_address; ?>" name="address" required>

            <label for="phone-number">Phone Number:</label>
            <input type="text" id="phone-number"value="<?php echo $current_phone_number; ?>" name="phone-number" required>
            
            <label for="profile-picture">Profile Picture:</label>
            <input type="file" id="profile-picture" accept="image/*">

            <input type="hidden" id="csrf_token" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">
            
            <button type="submit">Save Changes</button>
        </form>
    </div>

    <?php
        include 'templates/footer.php';
    ?>
</body>
</html>