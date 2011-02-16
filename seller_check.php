<?php
session_start();
require("./includes/config.inc.php");

if(!isset($_SESSION["user_id"])){
    header("location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$showuser = mysqli_query($conn, "SELECT * FROM users WHERE `user_id`='$user_id';");
$rowUser = mysqli_fetch_array($showuser);
$user_balance = $rowUser['user_balance'];
$seller_balance = $rowUser['seller_balance'];

if($rowUser['seller'] == '1'){

}else{
    header("location: index.php");
    exit();
}


