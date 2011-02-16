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


if(isset($_GET['invalid']) && isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET[id];
    $selectData = "SELECT * FROM `bin_request` WHERE `id`='$id' AND `accepted_seller`='$user_id'";
    $querySelectData = mysqli_query($conn, $selectData);
    
    if(mysqli_num_rows($querySelectData) == 1){
        if($fetchData['status'] == 'invalid'){
            header("location: ./seller_accepted_bin_request.php");
        }else{
        $fetchData = mysqli_fetch_assoc($querySelectData);
        $price = $fetchData['price'];
        $buyerId = $fetchData['user_id'];
        
        $selectBuyerDet = "SELECT * FROM `users` WHERE `user_id`='$buyerId'";
        $queryBuyerDet = mysqli_query($conn, $selectBuyerDet);
        $fetchBuyerDet = mysqli_fetch_assoc($queryBuyerDet);
        
        $oldBal = $fetchBuyerDet['user_balance'];
        
        $newBal = $oldBal+$price;
        
        $updateBalQuery = "UPDATE users SET `user_balance`='$newBal' WHERE `user_id`='$buyerId'";
        mysqli_query($conn, $updateBalQuery);
        
        if(!empty($fetchData['accepted_seller'])){
            $updateData = "UPDATE `bin_request` SET `status`='invalid' WHERE `id`='$id' AND `accepted_seller`='$user_id'";
            mysqli_query($conn, $updateData);
        }
            header("location: ./seller_accepted_bin_request.php");
        }
    }else{
        
    }
    
}

if(isset($_GET['accept']) && isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET[id];
    $selectData = "SELECT * FROM `bin_request` WHERE `id`='$id'";
    $querySelectData = mysqli_query($conn, $selectData);
    if(mysqli_num_rows($querySelectData) == 1){
        $fetchData = mysqli_fetch_assoc($querySelectData);
        if(empty($fetchData['accepted_seller'])){
            $updateData = "UPDATE `bin_request` SET `accepted_seller`='$user_id',`status`='accepted' WHERE `id`='$id'";
            mysqli_query($conn, $updateData);
        }
    }else{
        
    }
}
if(isset($_POST['deliverText']) && !empty($_POST['deliverText'])){
    $deliverText = $_POST['deliverText'];
    $id = $_POST['id'];
    if(isset($_POST['additionalNotes']) && !empty($_POST['additionalNotes'])){
        $additionalNotes = $_POST['additionalNotes'];
    }else{
        $additionalNotes = '';
    }
    $updateData = "UPDATE `bin_request` SET `deliver`='$deliverText',`note`='$additionalNotes',`status`='completed' WHERE `id`='$id'";
    mysqli_query($conn, $updateData);
    
    $selectData = "SELECT * FROM `bin_request` WHERE `id`='$id'";
    $querySelectData = mysqli_query($conn, $selectData);
    $fetchData = mysqli_fetch_assoc($querySelectData);
        
    $price = $fetchData['price']*0.75;
        
    $selectBuyerDet = "SELECT * FROM `users` WHERE `user_id`='$user_id'";
    $queryBuyerDet = mysqli_query($conn, $selectBuyerDet);
    $fetchBuyerDet = mysqli_fetch_assoc($queryBuyerDet);
    
    $oldBal = $fetchBuyerDet['seller_balance'];
    
    $newBal = (float)$oldBal+(float)$price;
    
    $updateBalQuery = "UPDATE users SET `seller_balance`='$newBal' WHERE `user_id`='$user_id'";
    mysqli_query($conn, $updateBalQuery);
    
    header("location: ./seller_accepted_bin_request.php");
    
    
}



require("./seller_nav.php");

    
    ?>
    
    
    
    <?php 
    
    
        if(isset($_GET['edit']) && isset($_GET['id']) && !empty($_GET['id'])){
    ?>
    
    <div id="main">		            
        <div class="new-box">
          <div class="card-header">
                       <h4 class="card-title">Deliver Bin:</h4>
          </div>
                <form method="POST" action="#" style="width: 100%;" onsubmit="return confirm('Do you agree to deliver this?');">
                    
    
                    <div class="form-sec" style="text-align: center">
                        <div class="form-group" style="margin: auto">
                            <labe style="">Delivery Text: </labe>
                            <br>
                            <textarea required name="deliverText" cols="50" rows="10"></textarea>
                        </div>
    
                        <div class="form-group" style="margin: auto">
                            <label style="">Additional Note: </label>
                            <br>
                            <textarea name="additionalNotes" cols="50" rows="5"></textarea>
                        </div>
    
    
                    </div>
                    
                      
                    <br>
                    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                      <input name="btnSearch" type="submit" class="btn btn-normal" id="btnSearch" value="DELIVER" style="margin: auto;display: block;">
         
                  </form>
        </div>
    </div>
    
    <?php
        }else{
    ?>
<div id="main">		            
    <div id="balance">
			<div class="section_content_deposit">
			    <div class="page-title">Accepted History</div>

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
			            
			            $selectData = "SELECT * FROM `bin_request` WHERE `accepted_seller`='$user_id'";
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
			            <?php 
			                if($row['status'] == 'completed'){
			                    echo "<td>Completed</td>";
			                }else if($row['status'] == 'invalid'){
			                    echo "<td>Marked as invalid</td>";
			                }else{ 
			            ?>
			            <td><a style="background: red; padding: 5px; border-radius: 5px; margin-right: 5px;" href="?invalid&id=<?php echo $row['id']; ?>">Invalid Bin</a>|<a style="background: green; padding: 5px; border-radius: 5px; margin-left: 5px;" href="?edit&id=<?php echo $row['id']; ?>">Deliver</a></td>
			            <?php } ?>
			        </tr>
			        <?php } }else{ ?>
			        <tr>
			            <td>Nothing Found!</td>
			        </tr>
			        <?php } ?>
			        
			        
				    </tbody>
			
		
            </table>
        </div>
    </div>
</div>

<?php } ?>
    