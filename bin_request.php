<?php
require("./header.php");
if ($checkLogin) {
    
    
    

	
	if(isset($_POST['bin']) && !empty($_POST['bin']) && isset($_POST['price']) && !empty($_POST['price'])){
	    $price = $_POST['price'];
	    if($user_info["user_balance"] < 1){
	        echo "<script>$(location).attr('href', './bin_request.php?error=not_have_enough_balanace!)');</script>";
	    }else{
	        if($user_info["user_balance"] < $price){
	            echo "<script>$(location).attr('href', './bin_request.php?error=your price more than your personal balance!');</script>";
	        }else{
	            $bin = $_POST['bin'];
	            $userId = $user_info["user_id"];
	            $userName = $user_info["user_name"];
	            $newBal = $user_info["user_balance"]-$price;
	            
	            $updateQuery = "UPDATE users SET `user_balance`='$newBal' WHERE `user_id`='$userId'";
	            mysqli_query($conn, $updateQuery);
	            
	            $insertData = "INSERT INTO `bin_request`(`bin`, `user_id`, `user_name`, `status`, `price`) VALUES ('$bin','$userId','$userName','requested','$price')";
	            mysqli_query($conn, $insertData);
	            echo "<script>$(location).attr('href', './bin_request.php?error=successfully requested!');</script>";
	        }
	    }
	    
	    
	}
	
	

	
?>
<style>
    td{
        padding: 0 !important;
    }
    tr{
        background: none !important;
    }
</style>
				<div class="page-title">BIN REQUEST</div>
				<div class="new-box" style="align-items: center;" id="balance">
					<form action="#" method="POST" onsubmit="return confirm('Do you really want to submit the form? the price will charged from your balance.');">
					    <table>
					        <tr>
					            <td><input type="text" name="bin" placeholder="BIN"></td>
					            <td><input type="number" name="price" min="1" max="<?php if( $user_info["user_balance"] < 1 ){ echo "0";}else{ echo $user_info["user_balance"]."$"; } ?>" placeholder="price"></td>
					            <td><?php if( $user_info["user_balance"] < 1 ){ ?> <a style="border: 1px solid #dedede; padding: 2px 5px; font-size: 12px" href="./deposit.php">Deposit First</a> <?php }else{ ?><input type="submit" value="Create Request"><?php } ?></td>
					        </tr>
					        <tr>
					            <td>ex: 435623</td>
					            <td>min 1 & max <?php if( $user_info["user_balance"] < 1 ){ echo "-";}else{ echo $user_info["user_balance"]."$"; } ?></td>
					        </tr>
					    </table>
					    
					    
					    
					</form>
					
					<br>
					<br>
					<br>
					<table>
					    <thead>
					        <tr>
					            <th>BIN</th>
					            <th>Status</th>
					            <th>Price</th>
					            <th>Delivery Details</th>
					            <th>Note</th>
					            <th>Created Id</th>
					        </tr>
					    </thead>
					    <tbody>
					        
					        <?php
					            
	                            $userId = $user_info["user_id"];
					            $selectData = "SELECT * FROM `bin_request` WHERE `user_id`='$userId'";
					            $querySelectData = mysqli_query($conn, $selectData);
					            if(mysqli_num_rows($querySelectData) > 0){
					                while($row = mysqli_fetch_assoc($querySelectData)){
					        ?>
					        <tr>
					            <td><?php echo $row['bin']; ?></td>
					            <td><?php echo $row['status']; ?></td>
					            <td><?php echo $row['price']; ?></td>
					            <td><?php echo $row['deliver']; ?></td>
					            <td><?php echo $row['note']; ?></td>
					            <td><?php echo $row['created_date']; ?></td>
					        </tr>
					        <?php } }else{ ?>
					        <tr>
					            <td>Nothing Found!</td>
					        </tr>
					        <?php } ?>
					    </tbody>
					</table>
					
				</div>
<style>
	.new-box h3{
		margin-bottom:0px;
	}

	.new-box p{
		margin-bottom: 20px !important;
		margin-top: 5px !important;
	}
</style>
<?php
}
else {
	require("./minilogin.php");
}
require("./footer.php");
?>