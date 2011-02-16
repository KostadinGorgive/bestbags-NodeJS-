<?php
require("./header.php");
if ($checkLogin) {
    
    if(isset($_GET['accept'])){
        $id = mysqli_real_escape_string($conn, $_GET['accept']);
        
        $query = mysqli_query($conn, "UPDATE `seller_reqs` SET `status`='1' WHERE `id` = '$id';");

        
    }elseif(isset($_GET['refuse'])){
        $id = mysqli_real_escape_string($conn, $_GET['refuse']);
		$result = $conn->query("SELECT * FROM `seller_reqs` WHERE `id`='$id';");
        $row = mysqli_fetch_array($result);
        $seller = $row['seller'];
        $amount = $row['amount'];
        
        $query = mysqli_query($conn, "UPDATE `seller_reqs` SET `status`='2' WHERE `id` = '$id';");
        
        $query2 = mysqli_query($conn, "UPDATE `users` SET seller_balance = seller_balance + '$amount' WHERE `user_id`='$seller';");
    }

?>

<div id="main">				<div id="config_manager">
					<div class="section_title">CONFIGS MANAGER</div>
					
					<div class="section_content">
						<table class="content_table">
							<tbody>
								<tr>
									<td class="formstyle centered">
										<strong>ID</strong>
									</td>
									<td class="formstyle centered">
										<strong>SELLER</strong>
									</td>
									<td class="formstyle centered">
										<strong>Amount</strong>
									</td>
									<td class="formstyle centered">
										<strong>Address</strong>
									</td>
									<td class="formstyle centered">
										<strong>Method</strong>
									</td>
									<td class="formstyle centered">
										<strong>ACTION</strong>
									</td>
								</tr>
								<?php
								
								$result = $conn->query("SELECT * FROM `seller_reqs` WHERE `status`='0';");
                                 while($row = mysqli_fetch_array($result)){
                                     
                                     echo '
                                     <tr class="formstyle">
    									<td class="centered">
    										<span>'.$row['id'].'</span>
    									</td>
    									<td class="bold centered">
    										<span>'.$row['seller'].'</span>
    									</td>
    									<td class="centered">
    										<span>'.$row['amount'].'</span>
    									</td>
    									<td class="centered">
    										<span>'.$row['addy'].'</span>
    									</td>
    									<td class="centered">
    										<span>'.$row['method'].'</span>
    									</td>
    									<td class="centered">
    										<span><a href="payouts.php?accept='.$row['id'].'">Accept</a> | <a href="payouts.php?refuse='.$row['id'].'">Refuse</a></span>
    									</td>
    								</tr>
                                     
                                     ';
                                 }
								
								?>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>

<?php
}
else {
	require("./minilogin.php");
}
require("./footer.php");
?>