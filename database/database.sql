PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS OrderItems;
DROP TABLE IF EXISTS OrderHistory;
DROP TABLE IF EXISTS ShoppingCart;
DROP TABLE IF EXISTS Wishlist;
DROP TABLE IF EXISTS Reviews;
DROP TABLE IF EXISTS Messages;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Items;
DROP TABLE IF EXISTS Categories;
DROP TABLE IF EXISTS Subcategory;
DROP TABLE IF EXISTS Sizes;
DROP TABLE IF EXISTS Conditions;
DROP TABLE IF EXISTS PriceProposals;

CREATE TABLE Categories (
    CategoryId INTEGER PRIMARY KEY AUTOINCREMENT,
    Name VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE Subcategory(
    SubCategoryId INTEGER PRIMARY KEY AUTOINCREMENT,
    Name VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE Sizes (
    SizeId INTEGER PRIMARY KEY AUTOINCREMENT,
    Name VARCHAR(20) UNIQUE NOT NULL
);

CREATE TABLE Conditions (
    ConditionId INTEGER PRIMARY KEY AUTOINCREMENT,
    Name VARCHAR(20) UNIQUE NOT NULL
);

CREATE TABLE Users (
    Id INTEGER PRIMARY KEY AUTOINCREMENT,
    Username VARCHAR(50) UNIQUE NOT NULL,
    Email VARCHAR(100) UNIQUE NOT NULL,
    PasswordHash VARCHAR(255) NOT NULL,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    AdminStatus INTEGER DEFAULT 0 NOT NULL CHECK (AdminStatus <= 2),
    Address VARCHAR(255) NOT NULL,
    PhoneNumber VARCHAR(9)
);


CREATE TABLE Items (
    Id INTEGER PRIMARY KEY AUTOINCREMENT,
    Name VARCHAR(100) NOT NULL,
    Description TEXT NOT NULL,
    Brand VARCHAR(50) NOT NULL ,
    Model VARCHAR(50),
    CategoryId INTEGER NOT NULL,
    Size VARCHAR(20) ,
    Price DECIMAL(10, 2) NOT NULL,
    ConditionId VARCHAR(20) NOT NULL,
    Available BOOLEAN NOT NULL,
    AvailableForDelivery BOOLEAN NOT NULL , 
    SubCategory VARCHAR(50),
    NumberOfImages INTEGER,
    Highlighted INTEGER DEFAULT 0 NOT NULL CHECK (Highlighted <= 1),

    UserId INTEGER NOT NULL,
    FOREIGN KEY (UserId) REFERENCES Users(Id) ON DELETE CASCADE
);

CREATE TABLE OrderHistory (
    OrderId INTEGER PRIMARY KEY AUTOINCREMENT,
    UserId INTEGER NOT NULL,
    OrderDate TIMESTAMP NOT NULL,
    TotalPrice DECIMAL(10, 2) NOT NULL,
    PaymentMethod VARCHAR(50) NOT NULL ,
    ShippingMethod VARCHAR(50) NOT NULL,
    Status TEXT CHECK(Status IN ('Pending', 'Completed', 'Cancelled')) NOT NULL,
    FOREIGN KEY (UserId) REFERENCES Users(Id)
);

CREATE TABLE OrderItems (
    OrderItemId INTEGER PRIMARY KEY AUTOINCREMENT,
    OrderId INTEGER NOT NULL,
    ItemId INTEGER NOT NULL,
    FOREIGN KEY (OrderId) REFERENCES OrderHistory(OrderId),
    FOREIGN KEY (ItemId) REFERENCES Items(Id)
);

CREATE TABLE PriceProposals(
    ProposalId INTEGER PRIMARY KEY AUTOINCREMENT,
    ItemId INTEGER NOT NULL,
    UserId INTEGER NOT NULL,
    Price DECIMAL(10, 2) NOT NULL,
    Status TEXT CHECK(Status IN ('Pending', 'Accepted')) NOT NULL,
    FOREIGN KEY (ItemId) REFERENCES Items(Id),
    FOREIGN KEY (UserId) REFERENCES Users(Id)
);

CREATE TABLE ShoppingCart (
    CartItemId INTEGER PRIMARY KEY AUTOINCREMENT,
    UserId INT NOT NULL,
    ItemId INT NOT NULL,
    FOREIGN KEY (UserId) REFERENCES Users(Id),
    FOREIGN KEY (ItemId) REFERENCES Items(Id)
);

CREATE TABLE Wishlist (
    WishlistId INTEGER PRIMARY KEY AUTOINCREMENT,
    UserId INT NOT NULL,
    ItemId INT NOT NULL,
    FOREIGN KEY (UserId) REFERENCES Users(Id),
    FOREIGN KEY (ItemId) REFERENCES Items(Id)
);

CREATE TABLE Reviews (
    ReviewId INTEGER PRIMARY KEY AUTOINCREMENT,
    Rating DECIMAL NOT NULL,
    Comment TEXT NOT NULL,
    Author INT,
    UserReviewed INT,
    ReviewDate DATE NOT NULL,
    FOREIGN KEY (Author) REFERENCES Users(Id),
    FOREIGN KEY (UserReviewed) REFERENCES Users(Id)
);

CREATE TABLE Messages(
    MessageId INTEGER PRIMARY KEY AUTOINCREMENT,
    Sender INTEGER,
    Receiver INTEGER,
    ItemId INTEGER,
    Content TEXT,
    Timestamp DATETIME,
    FOREIGN KEY (Receiver) REFERENCES Users(Id),
    FOREIGN KEY (Sender) REFERENCES Users(Id),
    FOREIGN KEY (ItemId) REFERENCES Items(Id)
);


-- Insert some sample data into Categories, Sizes, and Conditions tables

INSERT INTO Categories (Name) VALUES
    ('Electronics'),
    ('Books'),
    ('Fashion'),
    ('Appliances'),
    ('Outdoor'),
    ('Music');

INSERT INTO Sizes (Name) VALUES
    ('Small'),
    ('Medium'),
    ('Large');

INSERT INTO Conditions (Name) VALUES
    ('New'),
    ('Used'),
    ('Refurbished');

-- Inserting data into the Users table
INSERT INTO Users (Username, Email, PasswordHash, FirstName, LastName, AdminStatus, Address, PhoneNumber)
VALUES
    ('john_doe', 'john@example.com', '07dd38dbbb755e1a476a782f3606cd3e99df3266', 'John', 'Doe',0, 'Rua da Boavista, Porto', '123456789'),
    ('jane_smith', 'jane@example.com', '07dd38dbbb755e1a476a782f3606cd3e99df3266', 'Jane', 'Smith',0, 'Rua de Santa Catarina, Porto', '987654321'),
    ('alex_jones', 'alex@example.com', '07dd38dbbb755e1a476a782f3606cd3e99df3266', 'Alex', 'Jones',0, 'Avenida da Liberdade, Lisboa', '456123789'),
    ('emily_brown', 'emily@example.com', '07dd38dbbb755e1a476a782f3606cd3e99df3266', 'Emily', 'Brown',0, 'Rua Mouzinho da Silveira, Lisboa', '321654987'),
    ('mike_wilson', 'mike@example.com', 'e10adc3949ba59abbe56e057f20f883e', 'Mike', 'Wilson',0, 'Rua de Santa Maria, Braga', '789456123'),
    ('sarah_green', 'sarah@example.com', 'f899139df5e1059396431415e770c6dd', 'Sarah', 'Green',0, 'Avenida dos Aliados, Porto', '147258369'),
    ('chris_taylor', 'chris@example.com', 'c33367701511b4f6020ec61ded352059', 'Chris', 'Taylor',0, 'Rua Augusta, Lisboa', '963852741'),
    ('lisa_johnson', 'lisa@example.com', '5d41402abc4b2a76b9719d911017c592', 'Lisa', 'Johnson',0, 'Praça da República, Coimbra', '789123654'),
    ('ryan_miller', 'ryan@example.com', '07dd38dbbb755e1a476a782f3606cd3e99df3266', 'Ryan', 'Miller',2, 'Rua Direita, Faro', '654789123'),
    ('jessica_white', 'jessica@example.com', '098f6bcd4621d373cade4e832627b4f6', 'Jessica', 'White',0, 'Rua Serpa Pinto, Viseu', '321789456');
    
-- Inserting data into the Items table
INSERT INTO Items (Name, Description, Brand, CategoryId, Price, ConditionId, AvailableForDelivery, Available, NumberOfImages , Highlighted, UserId)
VALUES
    ('Smartphone', 'High-end smartphone with advanced features', 'Samsung', 1, 799.99, 1, true, true,5,0 , 1),
    ('Laptop', 'Powerful laptop for work and entertainment', 'Dell', 1, 1299.99, 1, true, true,1,0, 1),
    ('Headphones', 'Noise-cancelling headphones for immersive audio experience', 'Sony', 1, 249.99, 1, true, true,1,0, 2),
    ('Book', 'Best-selling novel by a renowned author', 'Penguin', 2, 19.99, 1, true, true,1,0, 2),
    ('Smartwatch', 'Smartwatch with health and fitness tracking features', 'Apple', 1, 299.99, 1, true, true,1,0, 3),
    ('Tablet', 'Portable tablet for productivity and entertainment', 'Microsoft', 1, 499.99, 1, true, true,1,0, 3),
    ('Camera', 'High-quality camera for capturing memories', 'Canon', 1, 699.99, 1, true, true,1,0, 4),
    ('Gaming Console', 'Next-gen gaming console for immersive gaming experience', 'Nintendo', 1, 399.99, 1, true, true,1,0,4),
    ('Backpack', 'Durable backpack for everyday use', 'Jansport', 3, 49.99, 1, true, true,1,0,5),
    ('Sneakers', 'Stylish sneakers for casual wear', 'Nike', 3, 89.99, 1, true, true,1,0,5),
    ('Smart Speaker', 'Voice-controlled smart speaker for home entertainment', 'Amazon', 1, 129.99, 1, true, true,1,0,6),
    ('T-shirt', 'Comfortable cotton t-shirt for everyday wear', 'Adidas', 3, 29.99, 1, true, true,1,0, 6),
    ('Coffee Maker', 'Automatic coffee maker for brewing delicious coffee', 'Keurig', 4, 149.99, 1, true, true,1,0, 7),
    ('Vacuum Cleaner', 'High-powered vacuum cleaner for efficient cleaning', 'Dyson', 4, 299.99, 1, true, true,1,0, 7),
    ('Wireless Mouse', 'Ergonomic wireless mouse for smooth navigation', 'Logitech', 1, 39.99, 1, true, true,1,0, 8),
    ('Keyboard', 'Mechanical keyboard with customizable RGB lighting', 'Razer', 1, 99.99, 1, true, true,1,0, 8),
    ('Hiking Boots', 'Sturdy hiking boots for outdoor adventures', 'Merrell', 3, 129.99, 1, true, true,1,0, 9),
    ('Camping Tent', 'Spacious camping tent for overnight trips', 'Coleman', 5, 199.99, 1, true, true,1,0, 9),
    ('Guitar', 'Acoustic guitar for playing beautiful melodies', 'Fender', 6, 399.99, 1, true, true,1,0, 10),
    ('Drone', 'High-performance drone for aerial photography', 'DJI', 1, 799.99, 1, true, true,1,0, 10);

-- Insert data into Reviews table
INSERT INTO Reviews (Rating, Comment, Author, UserReviewed, ReviewDate) VALUES
(4.5, 'Great product!', 1, 1, '2024-04-20'),
(3.8, 'Could be better.', 2, 1, '2024-04-21'),
(5.0, 'Excellent service!', 2, 1, '2024-04-22');

-- Inserting data into the Messages table
INSERT INTO Messages (Sender, Receiver, ItemId, Content, Timestamp) VALUES
    (1, 2, 2, "Hey Jane, did you receive my email?", '2024-04-01 08:30:00'),
    (2, 1, 2, "Yes John, I got it. I'll reply soon.", '2024-04-02 10:15:00'),
    (3, 2, 2, "Hello John, just checking in on the progress.", '2024-04-03 11:45:00'),
    (6, 2, 2, "Hi Alex, the project is going well. Any updates from your end?", '2024-04-04 14:20:00'),
    (4, 2, 2, "Hi John, could you please review the latest draft?", '2024-04-05 16:30:00'),
    (1, 2, 2, "Hey Emily, can you attend the meeting tomorrow?", '2024-04-06 09:45:00'),
    (5, 2, 2, "John, don't forget about the deadline for the report.", '2024-04-07 13:10:00'),
    (1, 2, 2, "Sarah, could you provide the latest sales figures?", '2024-04-08 17:00:00'),
    (7, 2, 2, "John, can we discuss the budget for next quarter?", '2024-04-09 10:30:00'),
    (8, 2, 2, "Lisa, have you finalized the contracts?", '2024-04-10 14:45:00'),
    (9, 2, 2, "Hey John, when are you available for a catch-up?", '2024-04-11 16:15:00'),
    (9, 2, 1, "Hey John, when are you available for a catch-up?", '2024-04-11 16:15:00'),
    (2, 9, 2, "Hey Joy, when are you available for a catch-up?", '2024-04-11 16:20:00'),
    (7, 2, 2, "Jessica, could you review the presentation slides?", '2024-04-12 11:00:00');