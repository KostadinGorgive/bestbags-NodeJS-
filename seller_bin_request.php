<?php

require("./seller_check.php");

$seller = $_SESSION["user_id"];
$error = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $amount = round(floatval(mysqli_real_escape_string($conn, $_POST['amount'])),2 );
    $addy = mysqli_real_escape_string($conn, $_POST['addy']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $Seller_Bal = number_format($seller_balance, 2, '.', '');
    if($Seller_Bal >= $amount && $amount >= 30){
        $query = mysqli_query($conn, "UPDATE `users` SET seller_balance = seller_balance - '$amount' WHERE `user_id`='$seller';");
        
        $sql = "INSERT INTO `seller_reqs`(`seller`, `amount`, `method`, `addy`) VALUES ('$seller','$amount','$method','$addy');";
          if ($stmt = $conn->prepare($sql)) {
              if ($stmt->execute()) {
                header('location: seller_dashboard.php');
                  exit();

              } else {
                  $error="SQL Error, please try again.";
              }
              // Close statement
              $stmt->close();
          }
    }else{
        $error = "Amount is too low or too high. ";
    }
    
    
}

require("./seller_nav.php");





    
    ?>
    
    
<div id="main">		            

    <div id="balance">
					<div class="section_content_deposit">
					    <div class="page-title">Requests History</div>

						<br>
						<table>
						    <thead>
						        <tr>
						            <th>ID</th>
									<th>Bin</th>
									<th>Status</th>
									<th>Price</th>
									<th>Craeted Date</th>
									<th>Action</th>
						        </tr>
						    </thead>
						    <tbody>
						        
					        <?php
					            
	                            $userId = $user_info["user_id"];
					            $selectData = "SELECT * FROM `bin_request` WHERE `status`='requested'";
					            $querySelectData = mysqli_query($conn, $selectData);
					            if(mysqli_num_rows($querySelectData) > 0){
					                while($row = mysqli_fetch_assoc($querySelectData)){
					        ?>
					        <tr>
					            <td><?php echo $row['id']; ?></td>
					            <td><?php echo $row['bin']; ?></td>
					            <td><?php echo $row['status']; ?></td>
					            <td><?php echo $row['price']; ?></td>
					            <td><?php echo $row['created_date']; ?></td>
					            <td><a style="background: green; padding: 5px; border-radius: 5px;" href="./seller_accepted_bin_request.php?accept&id=<?php echo $row['id']; ?>">Accept</a></td>
					        </tr>
					        <?php } }else{ ?>
					        <tr>
					            <td>Nothing Found!</td>
					        </tr>
					        <?php } ?>
					        
					        
						    </tbody>
					
				
</table></div></div></div>


    </div>
    
    