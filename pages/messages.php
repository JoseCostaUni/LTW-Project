<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Messages</title>
        <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,200..900;1,200..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
        <link href="../css/messages.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/dompurify@2.3.3/dist/purify.min.js"></script>
        <script src="js/messages.js"></script>
    </head>
    <body>
        <?php
            require_once (__DIR__ . '/../db_handler/DB.php');
            session_start();
        ?>

        <header>
            <?php
                include 'templates/header.php';
            ?>
        </header>

    <input type="hidden" name="csrf" id="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">

    <section class="messages-section">
        <article class="messages-rectangle">
            <h2>Messages</h2>
            <div class="messages-content">
            <?php 
            $db = new Database("../database/database.db");
            $userId = $_SESSION['userId'];

            $messages = $db->getMessagesUser($userId);
            
            foreach ($messages as $message) {
                $sender = $message->getSender();
                $item = $message->getItemId();
                ?>
                    <div class="user-box" data-user-id="<?php echo $sender->getId(); ?>" data-item-id="<?php echo $item->getId(); ?>">
                        <div class="user-container">
                            <img src="../assets/users/<?php echo $sender->getId(); ?>.png" alt="<?php echo $sender->getUsername(); ?>" id="user_image">
                            <img src="../assets/items/<?php echo $item->getId(); ?>-1.png" alt="<?php echo $item->getName(); ?>" id="item_image">
                            <h4><?php echo $item->getName(); ?></h4>
                            <h4><?php echo $message->printTimestamp(); ?></h4>
                        </div>
                    </div>
                <?php
            }
            ?>
            </div>

        </article>

        <article class="open-messages">
            <h2>Messages Hub</h2>
            <div class="user-messages">
            </div>    
            <form class = "text-box" action="../db_handler/action_send_message.php">
                <div class="text-box-container">
                    <input type="text" id="user-message-input" placeholder="Type a message here:">
                    <button type="submit" value="Submit" class="user-message-button"><i class="fa fa-paper-plane"></i></button>
                </div>
            </form>
        </article>
    </section>
        
        <footer>
            <?php
                include 'templates/footer.php';
            ?>
        </footer>
    </body>
    </html>