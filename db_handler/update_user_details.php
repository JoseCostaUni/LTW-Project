<?php
require_once (__DIR__ . '/DB.php');

$db = new Database("../database/database.db");

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['csrf']) || $_SESSION['csrf'] !== $_POST['csrf']) {
        header("Location: ../pages/profile.php");
        exit();
    }
}

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$userId = $_SESSION['userId'];
$username = $_POST['username'];
$email = $_POST['email'];
$address = $_POST['address'];
$phone_number = $_POST['phone-number'];
$password = $_POST['password'];

if (!empty($password)) {
    $password = sha1($password);
} else {
    $user = $db->getUserById($userId);
    $password = $user->getPasswordHash();
}

$tempFilename = $_SESSION['userId'] . '_temp.png';
$finalFilename = $_SESSION['userId'] . '.png';

$tempPath = '../assets/users/' . $tempFilename;
$finalPath = '../assets/users/' . $finalFilename;

if (file_exists($tempPath)) {
    rename($tempPath, $finalPath);
}

$db->saveProfileChanges($first_name,$last_name,$username,$email,$address,$phone_number,$password,$userId);

header("Location: ../pages/profile.php");
exit();

?>
