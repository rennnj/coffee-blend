<?php require "../includes/header.php"; ?>
<?php
require "../config/config.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location: http://localhost/coffee-blend');
    exit;
}

$cartCheck = $conn->prepare("SELECT COUNT(*) as total_items FROM cart WHERE user_id = :user_id");
$cartCheck->execute([':user_id' => $_SESSION['user_id']]);
$totalItems = $cartCheck->fetch(PDO::FETCH_ASSOC)['total_items'];

if ($totalItems == 0) {
    header('location: http://localhost/coffee-blend');
    exit;
}

if (!isset($_SESSION['user_id'])) {
    header("location: " . APPURL . "");
}

$deleteAll = $conn->query("DELETE FROM cart WHERE user_id='$_SESSION[user_id]'");
$deleteAll->execute();

header("location: cart.php");
