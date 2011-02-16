<?php
/*
Callback location, set this in blockonmics merchant page

For testing payments locally, use this:
localhost/bitcoin/check?secret=asecretcode&addr=[ADDRESS]&status=[STATUS CODE]&txid=[TXID]&value=[Amount paid in satoshi]
*/
require("./includes/config.inc.php");

function getBTCPrice($currency){
    $content = file_get_contents("https://www.blockonomics.co/api/price?currency=".$currency);
    $content = json_decode($content);
    $price = $content->price;
    return $price;
}

function BTCtoUSD($amount){
    $price = getBTCPrice("USD");
    return $amount * $price;
}

function USDtoBTC($amount){
    $price = getBTCPrice("USD");
    return $amount/$price;
}



$secretlocal = "7LA7J42YYJ25DE8EUWQRHRTA5XEV6FVY"; // Code in the callback, make sure this matches to what youve set

// Get all these values
$status = 0;
$txid = $_GET['txid'];
$value = $_GET['value'];
$status = $_GET['status'];
$addr = $_GET['addr'];
$secret = $_GET['secret'];

// Check all are set
if(empty($txid) || empty($value) || empty($addr) || empty($secret)){
    exit();
}

if($secret != $secretlocal){
    exit();
}

$showuser = mysqli_query($conn, "SELECT * FROM `addrs` WHERE `addr` = '$addr';");
$row_user = mysqli_fetch_array($showuser);


$user_id = $row_user['user_id'];
$user_name = $row_user['user_name'];
$value = $value/100000000;
$usd_value = round(BTCtoUSD($value),2);

$showinvoice = mysqli_query($conn, "SELECT * FROM `n_payments` WHERE `txid` = '$txid';");
if(mysqli_num_rows($showinvoice) > 0){
    $row_invoice = mysqli_fetch_array($showinvoice);
    $sql = "UPDATE `n_payments` SET `status`='$status' WHERE `txid` = '$txid';";
    
}else{
    
    $sql = "INSERT INTO `n_payments` (`txid`, `value`, `usd_value`, `addr`, `status`, `user_id`, `user_name`) VALUES ('$txid', '$value', '$usd_value', '$addr', '$status', '$user_id', '$user_name')";
}

mysqli_query($conn, $sql);
echo $sql;


// Expired
if($status < 0){
    exit();
}


if($status == 2){
    $sql = "UPDATE `users` SET user_balance = user_balance + '$usd_value' WHERE user_id='$user_id';";
    mysqli_query($conn, $sql);
    echo $sql;
}
    
    

?>