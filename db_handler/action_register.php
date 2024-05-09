<?php 
declare(strict_types = 1);

session_start();

require_once(__DIR__ . '/connection.php');
require_once(__DIR__ . '/user_Reg_info.php');
require_once (__DIR__ . '/DB.php');

$db = new DB();
$dbh = $db->get_database_connection();



$usr = new User($Id, $_POST['username'], $_POST['email'], $_POST['password'], $_POST['firstname'], $_POST['lastname'], $_POST['address'], $_POST['phonenumber']);
register_user($dbh, $Id, $usr);
$usr->displayDetails();
$_SESSION['email'] = $_POST['email'];
$dB = new Database("../database/database.db");
$user = $dB->getUserByEmail($_POST['email']);
$userId = $user->getId();
$_SESSION['userId'] = $userId;

header("Location: ../pages/homepage.php");