<?php
declare(strict_types=1);
require_once 'Item.php';
require_once 'OrderHistory.php';
require_once 'OrderItems.php';
require_once 'ShoppingCart.php';
require_once 'Users.php';
require_once 'Wishlist.php';
require_once 'Reviews.php';
require_once 'Message.php';
require_once 'Categories.php';
require_once 'Conditions.php';
require_once 'SubCategory.php';
require_once 'SIzes.php';
require_once 'PriceProposal.php';

class Database
{
    private static $instance = null;
    private $conn;

    public function __construct($databasePath)
    {

        try {
            $this->conn = new PDO("sqlite:$databasePath");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database('../database/database.db');
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->conn;
    }

    public function getCategoryNameById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE CategoryId = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row !== false) {
            return $row['Name'];
        } else {
            return null;
        }
    }

    public function deleteItemMessages($itemId)
    {
        $stmt = $this->conn->prepare("DELETE FROM Messages WHERE ItemId = :itemId");
        $stmt->bindParam(':itemId', $itemId);
        $stmt->execute();
    }

    public function deleteItemShoppingCart($itemId)
    {
        $stmt = $this->conn->prepare("DELETE FROM ShoppingCart WHERE ItemId = :itemId");
        $stmt->bindParam(':itemId', $itemId);
        $stmt->execute();
    }

    public function deleteItemWishlist($itemId)
    {
        $stmt = $this->conn->prepare("DELETE FROM Wishlist WHERE ItemId = :itemId");
        $stmt->bindParam(':itemId', $itemId);
        $stmt->execute();
    }

    public function getConditionNameById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Conditions WHERE ConditionId = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row !== false) {
            return $row['Name'];
        } else {
            return null;
        }
    }

    public function getSizeNameById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Sizes WHERE SizeId = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row !== false) {
            return $row['Name'];
        } else {
            return null;
        }
    }

    public function getSizes()
    {
        $stmt = $this->conn->prepare("SELECT * FROM Sizes");
        $stmt->execute();
        $sizes = [];
        while ($row = $stmt->fetch()) {
            $sizes[] = new Size($row['SizeId'], $row['Name']);
        }
        return $sizes;
    }

    public function getConditions()
    {
        $stmt = $this->conn->prepare("SELECT * FROM Conditions");
        $stmt->execute();
        $conditions = [];
        while ($row = $stmt->fetch()) {
            $conditions[] = new Condition($row['ConditionId'], $row['Name']);
        }
        return $conditions;
    }

    public function getAllSubCategories(): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM Subcategory");
        $stmt->execute();
        $subCategories = [];
        while ($row = $stmt->fetch()) {
            $subCategories[] = new SubCategory($row['SubCategoryId'], $row['Name']);
        }
        return $subCategories;
    }

    public function getSubCategoryNameById($id): string
    {
        $stmt = $this->conn->prepare("SELECT * FROM Subcategory WHERE SUbCategoryId = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['Name'];
    }


    public function getItemById($id): Item
    {
        $stmt = $this->conn->prepare("SELECT * FROM items WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch();
        return new Item(
            $row['Id'],
            $row['Name'],
            $row['Description'],
            $row['Brand'],
            $row['Model'],
            $row['CategoryId'],
            $row['Size'],
            $row['Price'],
            $row['ConditionId'],
            $row['Available'],
            $row['AvailableForDelivery'],
            $row['SubCategory'],
            $row['NumberOfImages'],
            $row['Highlighted'],
            $row['UserId']
        );
    }

    public function getXRandomSubCategories(int $x): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM Subcategory ORDER BY RANDOM() LIMIT :x");
        $stmt->bindParam(':x', $x);
        $stmt->execute();
        $subCategories = [];
        while ($row = $stmt->fetch()) {
            $subCategories[] = new SubCategory($row['SUbCategoryId'], $row['ParentCategory'], $row['Name']);
        }
        return $subCategories;
    }

    public function getXRandomCategories(int $x): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM categories ORDER BY RANDOM() LIMIT :x");
        $stmt->bindParam(':x', $x);
        $stmt->execute();
        $categories = [];
        while ($row = $stmt->fetch()) {
            $categories[] = [
                'id' => $row['CategoryId'],
                'name' => $row['Name']
            ];
        }
        return $categories;
    }

    public function deleteConditionById($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM Conditions WHERE ConditionId = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function deleteSizeById($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM Sizes WHERE SizeId = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function deleteSubCategoryById($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM Subcategory WHERE SUbCategoryId = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

        public function deleteCategoryById($id) {
            $stmt = $this->conn->prepare("DELETE FROM Categories WHERE CategoryId = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }

        public function deleteItemProposals($itemId){
            $stmt = $this->conn->prepare("DELETE FROM PriceProposals WHERE ItemId = :itemId");
            $stmt->bindParam(':itemId', $itemId);
            $stmt->execute();
        }

    public function getCategories(): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM categories");
        $stmt->execute();
        $categories = [];
        while ($row = $stmt->fetch()) {
            $categories[] = new Category($row['CategoryId'], $row['Name']);
        }
        return $categories;
    }

    public function getSubCategoryById($id): SubCategory
    {
        $stmt = $this->conn->prepare("SELECT * FROM subcategories WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch();
        return new SubCategory($row['SUbCategoryId'], $row['ParentCategory'], $row['Name']);
    }

    public function getCategoryById($id): Category
    {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE CategoryId = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch();
        return new Category($row['CategoryId'], $row['Name']);
    }

    public function getItemsName(): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM items");
        $stmt->execute();
        $items = [];
        while ($row = $stmt->fetch()) {
            $items[] = $row['Name'];
        }
        return $items;
    }

    public function getItems(): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM Items");
        $stmt->execute();
        $items = [];
        while ($row = $stmt->fetch()) {
            $items[] = new Item(
                $row['Id'],
                $row['Name'],
                $row['Description'],
                $row['Brand'],
                $row['Model'],
                $row['CategoryId'],
                $row['Size'],
                $row['Price'],
                $row['ConditionId'],
                $row['Available'],
                $row['AvailableForDelivery'],
                $row['SubCategory'],
                $row['NumberOfImages'],
                $row['Highlighted'],

                $row['UserId']
            );
        }
        return $items;
    }

    public function getAllItems(): array
    {

        $stmt = $this->conn->prepare("SELECT * FROM Items");
        $stmt->execute();
        $items = [];
        while ($row = $stmt->fetch()) {
            $items[] = [
                $row['Id'],
                $row['Name'],
                $row['Description'],
                $row['Category'],
                $row['Price'],
                $row['Condition'],
                $row['Available'],
                $row['UserId'],
                $row['photo_img_col']
            ];
        }
        return $items;
    }

    public function getItemByUserId($userId): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM Items WHERE UserId = :userId AND Available = 1");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $items = [];
        while ($row = $stmt->fetch()) {
            $items[] = new Item(
                $row['Id'],
                $row['Name'],
                $row['Description'],
                $row['Brand'],
                $row['Model'],
                $row['CategoryId'],
                $row['Size'],
                $row['Price'],
                $row['ConditionId'],
                $row['Available'],
                $row['AvailableForDelivery'],
                $row['SubCategory'],
                $row['NumberOfImages'],
                $row['Highlighted'],

                $row['UserId']
            );
        }
        return $items;
    }

    public function getAllUsers(): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM Users");
        $stmt->execute();
        $users = [];
        while ($row = $stmt->fetch()) {
            $users[] = new User(
                $row['Id'],
                $row['Username'],
                $row['Email'],
                $row['PasswordHash'],
                $row['FirstName'],
                $row['LastName'],
                $row['AdminStatus'],
                $row['Address'],
                $row['PhoneNumber']
            );
        }
        return $users;
    }

    public function getAllCategoriesName(): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM Categories");
        $stmt->execute();
        $categories = [];
        while ($row = $stmt->fetch()) {
            $categories[] = $row['Name'];
        }
        return $categories;
    }

    public function getAllSizesNames()
    {
        $stmt = $this->conn->prepare("SELECT * FROM Sizes");
        $stmt->execute();
        $sizes = [];
        while ($row = $stmt->fetch()) {
            $sizes[] = $row['Name'];
        }
        return $sizes;
    }

    public function getAllSubCategoryName(): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM Subcategory");
        $stmt->execute();
        $subCategories = [];
        while ($row = $stmt->fetch()) {
            $subCategories[] = $row['Name'];
        }
        return $subCategories;
    }

    public function getAllConditionsName(): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM Conditions");
        $stmt->execute();
        $conditions = [];
        while ($row = $stmt->fetch()) {
            $conditions[] = $row['Name'];
        }
        return $conditions;
    }

    public function getAllSubCategoriesNames(): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM Subcategory");
        $stmt->execute();
        $subCategories = [];
        while ($row = $stmt->fetch()) {
            $subCategories[] = $row['Name'];
        }
        return $subCategories;
    }




    public function insertItem($name, $description, $brand, $model, $category, $size, $price, $condition, $available, $available_for_delivery, $subCategory, $numberOfImages, $userId)
    {
        $highlighted = 0;
        $stmt = $this->conn->prepare("INSERT INTO Items (Name, Description, Brand, Model, CategoryId, Size,  Price, ConditionId, Available, AvailableForDelivery, SubCategory, NumberOfImages,Highlighted, UserId) VALUES (:name, :description, :brand, :model, :category, :size, :price, :condition, :available, :delivery, :subCategory, :numImages, :highlighted, :userId)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':brand', $brand);
        $stmt->bindParam(':model', $model);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':size', $size);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':condition', $condition);
        $stmt->bindParam(':available', $available);
        $stmt->bindParam(':delivery', $available_for_delivery);
        $stmt->bindParam(':subCategory', $subCategory);
        $stmt->bindParam(':numImages', $numberOfImages);
        $stmt->bindParam(':highlighted', $highlighted);
        $stmt->bindParam(':userId', $userId);

        $stmt->execute();
    }

    public function insertImageOnItem(int $itemId, array $imageData): void
    {
        if (!isset($imageData['name']) || !isset($imageData['tmp_name']) || !isset($imageData['error']) || !isset($imageData['size'])) {
            echo "Error: Invalid image data.";
            return;
        }

        if ($imageData['error'] !== UPLOAD_ERR_OK) {
            echo "Error uploading image: " . $imageData['error'];
            return;
        }
        // Temporary file path
        $tempImagePath = $imageData['tmp_name'];

        // Call the Python script with the item ID and temporary image path
        $command = 'python3 insert_image.py ' . $itemId . ' ' . escapeshellarg($tempImagePath);
        $output = exec($command);
        echo $output;
    }

    public function updateItem(Item $item)
    {
        $stmt = $this->conn->prepare("UPDATE items SET name = :name, description = :description, category = :category, price = :price, condition = :condition, available = :available, userId = :userId WHERE id = :id");
        $stmt->bindParam(':name', $item->name);
        $stmt->bindParam(':description', $item->description);
        $stmt->bindParam(':category', $item->category);
        $stmt->bindParam(':price', $item->price);
        $stmt->bindParam(':condition', $item->condition);
        $stmt->bindParam(':available', $item->available);
        $stmt->bindParam(':userId', $item->userId);
        $stmt->bindParam(':id', $item->id);
        $stmt->execute();
    }

    public function deleteItem($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM items WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function insertOrderHistory(OrderHistory $orderHistory)
    {
        $stmt = $this->conn->prepare("INSERT INTO OrderHistory (OrderId , UserId, OrderDate, TotalPrice, Status) VALUES (:orderId, :userId, :orderDate, :totalPrice, :status)");
        $stmt->bindParam(':userId', $orderHistory->UserId);
        $stmt->bindParam(':orderDate', $orderHistory->OrderDate);
        $stmt->bindParam(':totalPrice', $orderHistory->TotalPrice);
        $stmt->bindParam(':status', $orderHistory->Status);
        $stmt->bindParam(':orderId', $orderHistory->OrderId);
        $stmt->execute();
    }

    public function getAllUserItems(int $id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM items WHERE UserId = :id AND Available = 1");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $items = [];
        while ($row = $stmt->fetch()) {
            $items[] = new Item(
                $row['Id'],
                $row['Name'],
                $row['Description'],
                $row['Brand'],
                $row['Model'],
                $row['CategoryId'],
                $row['Size'],
                $row['Price'],
                $row['ConditionId'],
                $row['Available'],
                $row['AvailableForDelivery'],
                $row['SubCategory'],
                $row['NumberOfImages'],
                $row['Highlighted'],

                $row['UserId']
            );
        }
        return $items;
    }

        public function getXRandItems(int $x) : array {
            $stmt = $this->conn->prepare("SELECT * FROM items WHERE Available = 1 ORDER BY Highlighted DESC, RANDOM() LIMIT :x");
            $stmt->bindParam(':x', $x);
            $stmt->execute();
            $items = [];
            while ($row = $stmt->fetch()) {
                $items[] = new Item(
                    $row['Id'],
                    $row['Name'],
                    $row['Description'],
                    $row['Brand'],
                    $row['Model'],
                    $row['CategoryId'],
                    $row['Size'],
                    $row['Price'],
                    $row['ConditionId'],
                    $row['Available'],
                    $row['AvailableForDelivery'],
                    $row['SubCategory'],
                    $row['NumberOfImages'],
                    $row['Highlighted'],

                $row['UserId']
            );
        }
        return $items;
    }

    function getUserById($userId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Users WHERE Id = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return new User(
                $user['Id'],
                $user['Username'],
                $user['Email'],
                $user['PasswordHash'],
                $user['FirstName'],
                $user['LastName'],
                $user['AdminStatus'],
                $user['Address'],
                $user['PhoneNumber']
            );
        } else {
            return null;
        }
    }

    public function getReviewByReviewedUserId($userId): array
    {
        $stmt = $this->conn->prepare("
            SELECT * 
            FROM 
                Reviews 
            JOIN 
                Users ON Reviews.Author = Users.Id
            WHERE 
                Reviews.UserReviewed = :userId
            ORDER BY Reviews.ReviewDate DESC;    
            ");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $reviews = [];
        while ($row = $stmt->fetch()) {
            $author = $this->getUserById($row['Author']);

            $review = new Review(
                $row['ReviewId'],
                $row['Rating'],
                $row['Comment'],
                $author,
                $row['UserReviewed'],
                $row['ReviewDate']
            );

            $reviews[] = $review;
        }
        return $reviews;
    }

    public function getUserByEmail($email): User
    {
        $stmt = $this->conn->prepare("SELECT * FROM Users WHERE Email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return new User(
                $user['Id'],
                $user['Username'],
                $user['Email'],
                $user['PasswordHash'],
                $user['FirstName'],
                $user['LastName'],
                $user['AdminStatus'],
                $user['Address'],
                $user['PhoneNumber']
            );
        } else {
            return null;
        }
    }

    public function getMessagesUser($userId): array
    {
        $stmt = $this->conn->prepare("
            SELECT m.*
            FROM Messages m
            JOIN (
            SELECT Sender, Receiver, ItemId, MAX(Timestamp) AS MaxTimestamp
            FROM Messages
            WHERE Receiver = :userId
            GROUP BY Sender, Receiver, ItemId
            UNION
            SELECT Sender, Receiver, ItemId, MAX(Timestamp) AS MaxTimestamp
            FROM Messages
            WHERE Sender = :userId AND Content = 'Hello, is this item still available?'
            GROUP BY Sender, Receiver, ItemId
            ) AS MaxMsg ON m.Sender = MaxMsg.Sender AND m.Receiver = MaxMsg.Receiver AND m.ItemId = MaxMsg.ItemId AND m.Timestamp = MaxMsg.MaxTimestamp
            ORDER BY MaxMsg.MaxTimestamp DESC;
        ");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        $messages = [];

        while ($message = $stmt->fetch()) {
            $sender = $this->getUserById($message['Sender']);
            $receiver = $this->getUserById($message['Receiver']);
            $item = $this->getItemById($message['ItemId']);

            $new_message = new Message(
                $message['MessageId'],
                $sender,
                $receiver,
                $item,
                $message['Content'],
                $message['Timestamp']
            );

            $messages[] = $new_message;

        }

        return $messages;
    }


    public function getMessagesSenderToUser($userId, $senderId, $itemId): array
    {
        $stmt = $this->conn->prepare("
            SELECT * FROM Messages
            WHERE Sender = :userId AND Receiver = :senderId AND ItemId = :itemId
            UNION
            SELECT * FROM Messages
            WHERE Sender = :senderId AND Receiver = :userId AND ItemId = :itemId
            ORDER BY Timestamp ASC");

        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':senderId', $senderId);
        $stmt->bindParam(':itemId', $itemId);
        $stmt->execute();

        $messages = [];

        while ($message = $stmt->fetch()) {
            $sender = $this->getUserById($message['Sender']);
            $receiver = $this->getUserById($message['Receiver']);
            $item = $this->getItemById($message['ItemId']);
            $new_message = new Message(
                $message['MessageId'],
                $sender,
                $receiver,
                $item,
                $message['Content'],
                $message['Timestamp']
            );

            $messages[] = $new_message;

        }

        return $messages;
    }

    public function saveMessagesDb($senderId, $receiverId, $itemId, $message)
    {
        $timestamp = date("Y-m-d H:i:s");

        $stmt = $this->conn->prepare("INSERT INTO Messages (Sender, Receiver, ItemId, Content, Timestamp) VALUES (:senderId, :receiverId, :itemId, :message_content, :time_now)");

        $stmt->bindParam(':senderId', $senderId);
        $stmt->bindParam(':receiverId', $receiverId);
        $stmt->bindParam(':message_content', $message);
        $stmt->bindParam(':itemId', $itemId);
        $stmt->bindParam(':time_now', $timestamp);

        $stmt->execute();
    }


    public function saveProfileChanges($first_name, $last_name, $username, $email, $address, $phone_number, $password, $userId)
    {

        $stmt = $this->conn->prepare("UPDATE users SET FirstName = :first_name, LastName = :last_name, Email = :email,Username = :username, Address = :address, PhoneNumber = :phone_number, PasswordHash = :password WHERE Id = :user_id");

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':password', $password);

        $stmt->execute();
    }

    public function saveReviewsDb($rating, $comment, $author, $userReviewed)
    {
        $timestamp = date("Y-m-d H:i:s");

        $stmt = $this->conn->prepare("INSERT INTO Reviews(Rating, Comment, Author, UserReviewed, ReviewDate) VALUES (:rating, :comment, :author, :userReviewed, :time_now)");

        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':userReviewed', $userReviewed);
        $stmt->bindParam(':time_now', $timestamp);

        $stmt->execute();
    }


    public function addParameterAdmin($table, $parameter)
    {
        $stmt = $this->conn->prepare("INSERT INTO $table('Name') VALUES (:parameter)");

        $stmt->bindParam(':parameter', $parameter);

        $stmt->execute();
    }

    public function deleteParameterAdmin($table, $parameter)
    {
        $stmt = $this->conn->prepare("DELETE FROM $table WHERE Name = :parameter");

        $stmt->bindParam(':parameter', $parameter);

        $stmt->execute();
    }

    public function deteleUserbyId($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM Users WHERE Id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function deleteUserItems($userId)
    {
        $stmt = $this->conn->prepare("DELETE FROM Items WHERE UserId = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
    }

    public function deleteUserMessages($userId)
    {
        $stmt = $this->conn->prepare("DELETE FROM Messages WHERE Sender = :userId OR Receiver = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
    }

    public function deleteUserReviews($userId)
    {
        $stmt = $this->conn->prepare("DELETE FROM Reviews WHERE Author = :userId OR UserReviewed = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
    }

    public function deleteUserWishlist($userId)
    {
        $stmt = $this->conn->prepare("DELETE FROM Wishlist WHERE UserId = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
    }

    public function deleteUserShoppingCart($userId)
    {
        $stmt = $this->conn->prepare("DELETE FROM ShoppingCart WHERE UserId = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
    }

    public function deleteUserOrderHistory($userId)
    {
        $stmt = $this->conn->prepare("DELETE FROM OrderHistory WHERE UserId = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
    }

    public function UpdateUserAdminStatus($userId, $adminStatus)
    {
        $stmt = $this->conn->prepare("UPDATE Users SET AdminStatus = :adminStatus WHERE Id = :userId");
        $stmt->bindParam(':adminStatus', $adminStatus);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
    }

    public function UpdateItemPriority($itemId, $priority)
    {
        $stmt = $this->conn->prepare("UPDATE Items SET Priority = :priority WHERE Id = :itemId");
        $stmt->bindParam(':priority', $priority);
        $stmt->bindParam(':itemId', $itemId);
        $stmt->execute();
    }

    public function UpdateItemHighlighted($itemId, $highlighted)
    {
        $stmt = $this->conn->prepare("UPDATE Items SET Highlighted = :highlighted WHERE Id = :itemId");
        $stmt->bindParam(':highlighted', $highlighted);
        $stmt->bindParam(':itemId', $itemId);
        $stmt->execute();
    }

    public function getWishlistItems($userId): array
    {   
        if($userId == null){
            return [];
        }
        $stmt = $this->conn->prepare("SELECT * FROM Wishlist WHERE UserId = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $wishlistItems = [];
        while ($row = $stmt->fetch()) {
            $wishlistItems[] = $row['ItemId'];
        }
        return $wishlistItems;
    }

    public function getcartitems($userId): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM ShoppingCart WHERE UserId = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $cartItems = [];
        while ($row = $stmt->fetch()) {
            $cartItems[] = $row['ItemId'];
        }
        return $cartItems;

    }

    public function getPriceProposalByUserId($itemId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM PriceProposals WHERE ItemId = :itemId AND Status='Pending' ORDER BY Price DESC LIMIT 1");
        $stmt->bindParam(':itemId', $itemId);
        $stmt->execute();
        $priceProposal = $stmt->fetch();
        if ($priceProposal) {
            return new PriceProposal($priceProposal['ProposalId'], $priceProposal['Price'], $priceProposal['UserId'], $priceProposal['ItemId'], $priceProposal['Status']);
        } else {
            return null;
        }
    }

    public function EliminateItemProposal($itemId, $price)
    {
        $stmt = $this->conn->prepare("DELETE FROM PriceProposals WHERE ItemId = :itemId AND Price = :price");
        $stmt->bindParam(':itemId', $itemId);
        $stmt->bindParam(':price', $price);
        $stmt->execute();
    }

    public function InsertItemProposal($itemId, $userId, $price)
    {
        $stmt = $this->conn->prepare("INSERT INTO PriceProposals (Price, UserId, ItemId, Status) VALUES (:price, :userId, :itemId, 'Pending')");
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':itemId', $itemId);
        $stmt->execute();
    }

    public function UpdateItemPrice($itemId, $newPrice)
    {
        $stmt = $this->conn->prepare("UPDATE Items SET Price = :newPrice WHERE Id = :itemId");
        $stmt->bindParam(':newPrice', $newPrice);
        $stmt->bindParam(':itemId', $itemId);
        $stmt->execute();
    }

        public function AddOrderHistory($userId,$totalPrice,$shippingMethod,$paymentMethod){
            $stmt = $this->conn->prepare("INSERT INTO OrderHistory (UserId, OrderDate, PaymentMethod, ShippingMethod, TotalPrice, Status) VALUES (:userId, :orderDate, :payment, :shipping, :totalPrice, 'Completed')");
            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':orderDate', date("Y-m-d H:i:s"));
            $stmt->bindParam(':totalPrice', $totalPrice);
            $stmt->bindParam(':shipping', $shippingMethod);
            $stmt->bindParam(':payment', $paymentMethod);
            $stmt->execute();
        }

        public function RetrieveLastOrderHistory(){
            $stmt = $this->conn->prepare("SELECT OrderId FROM OrderHistory ORDER BY OrderId DESC LIMIT 1");
            $stmt->execute();
            $orderHistory = $stmt->fetch();
            if ($orderHistory) {
                return $orderHistory['OrderId'];
            } else {
                return null;
            }
        }

        public function AddOrderItem($orderId,$itemId){
            $stmt = $this->conn->prepare("INSERT INTO OrderItems (OrderId, ItemId) VALUES (:orderId, :itemId)");
            $stmt->bindParam(':orderId', $orderId);
            $stmt->bindParam(':itemId', $itemId);
            $stmt->execute();
        }

        public function UpdateItemNotAvailable($itemId){
            $stmt = $this->conn->prepare("UPDATE Items SET Available = 0 WHERE Id = :itemId");
            $stmt->bindParam(':itemId', $itemId);
            $stmt->execute();
        }

        public function GetItemsAlreadySold($userId) : array{
            $stmt = $this->conn->prepare("SELECT * FROM Items WHERE UserId = :userId AND Available = 0");
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
            $items = [];
        while ($row = $stmt->fetch()) {
            $items[] = new Item(
                $row['Id'],
                $row['Name'],
                $row['Description'],
                $row['Brand'],
                $row['Model'],
                $row['CategoryId'],
                $row['Size'],
                $row['Price'],
                $row['ConditionId'],
                $row['Available'],
                $row['AvailableForDelivery'],
                $row['SubCategory'],
                $row['NumberOfImages'],
                $row['Highlighted'],
                $row['UserId']
            );
        }
            return $items;
        }

        public function getOrderHistoryByUserId($userId) : array{
            $stmt = $this->conn->prepare("SELECT * FROM OrderHistory WHERE UserId = :userId");
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
            $orderHistory = [];
            while ($row = $stmt->fetch()) {
                $orderHistory[] = new OrderHistory(
                    $row['OrderId'],
                    $row['UserId'],
                    $row['OrderDate'],
                    $row['TotalPrice'],
                    $row['PaymentMethod'],
                    $row['ShippingMethod'],
                    $row['Status']
                );
            }
            return $orderHistory;
        }

        public function getOrderItemsByOrderId($orderId) : array{
            $stmt = $this->conn->prepare("SELECT * FROM OrderItems WHERE OrderId = :orderId");
            $stmt->bindParam(':orderId', $orderId);
            $stmt->execute();
            $orderItems = [];
            while ($row = $stmt->fetch()) {
                $orderItems[] = new OrderItem(
                    $row['OrderItemId'],
                    $row['OrderId'],
                    $row['ItemId']
                );
            }
            return $orderItems;
        }

        public function getCategoryIdByName($name){
            $stmt = $this->conn->prepare("SELECT CategoryId FROM Categories WHERE Name = :name");
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $category = $stmt->fetch();
            if ($category) {
                return $category['CategoryId'];
            } else {
                return null;
            }
        }

        public function getSubCategoryIdByName($name){
            $stmt = $this->conn->prepare("SELECT SubCategoryId FROM Subcategory WHERE Name = :name");
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $subCategory = $stmt->fetch();
            if ($subCategory) {
                return $subCategory['SubCategoryId'];
            } else {
                return null;
            }
        }

        public function getConditionIdByName($name){
            $stmt = $this->conn->prepare("SELECT ConditionId FROM Conditions WHERE Name = :name");
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $condition = $stmt->fetch();
            if ($condition) {
                return $condition['ConditionId'];
            } else {
                return null;
            }
        }

        public function getOrderHistoryById($orderId){
            $stmt = $this->conn->prepare("SELECT * FROM OrderHistory WHERE OrderId = :orderId");
            $stmt->bindParam(':orderId', $orderId);
            $stmt->execute();
            $orderHistory = $stmt->fetch();
            if ($orderHistory) {
                return new OrderHistory(
                    $orderHistory['OrderId'],
                    $orderHistory['UserId'],
                    $orderHistory['OrderDate'],
                    $orderHistory['TotalPrice'],
                    $orderHistory['PaymentMethod'],
                    $orderHistory['ShippingMethod'],
                    $orderHistory['Status']
                );
            } else {
                return null;
            }
        }
    }
?>