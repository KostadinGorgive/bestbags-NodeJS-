<?php
require("./header.php");
if ($checkLogin) {
    if(isset($_GET['seller'])){
        
        $id = mysqli_real_escape_string($conn, $_GET['seller']);
        $result = mysqli_query($conn,"UPDATE `users` SET `seller`='1' WHERE `user_id`='$id';");
        $yourURL="https://majorcc.shop/21232f297a57a5a743894a0e4a801fc3/users.php";
        echo ("<script>location.href='$yourURL'</script>");
        
    }elseif(isset($_GET['remove'])){
        
        $id = mysqli_real_escape_string($conn, $_GET['remove']);
        $result = mysqli_query($conn,"UPDATE `users` SET `seller`='0' WHERE `user_id`='$id';");
        $yourURL="https://majorcc.shop/21232f297a57a5a743894a0e4a801fc3/users.php";
        echo ("<script>location.href='$yourURL'</script>");
    }
}