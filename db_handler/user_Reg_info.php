<?php 
declare(strict_types = 1);
require_once(__DIR__ . '/connection.php');
require_once(__DIR__ . '/Users.php');

function register_user($dbh, $Id, User $user): void {
    $query = $dbh->prepare('INSERT INTO Users (Username, Email, PasswordHash, FirstName, LastName, Address, PhoneNumber) VALUES ( ?, ?, ?, ?, ?, ?, ?)');
    $query->execute(array( $user->getUsername(), $user->getEmail(), sha1($user->getPasswordHash()), $user->getFirstName(), $user->getLastName(), $user->getAddress(), $user->getPhoneNumber()));
    header('Location: homepage.php');
}


function verify_user(PDO $dbh, string $email, string $password): bool{
    $stmt = $dbh->prepare('SELECT * FROM Users WHERE Email = ? AND PasswordHash = ?');
    $stmt->execute(array($email, sha1($password)));

    $user = $stmt->fetch();
    if ($user) {
        return true;
    } else {
        return false;
    }
}
?>