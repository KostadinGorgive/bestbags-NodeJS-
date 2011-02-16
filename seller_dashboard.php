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





if(isset($_GET['history'])){
    
    ?>
    
    
<div id="main">		            

    <div id="balance">
					<div class="section_content_deposit">
					    <a href="seller_dashboard.php" class="btn btn-normal" value="SUBMIT" style="float: right;">BACK</a>
					    <div class="page-title">Requests History</div>

						<br>
						<table>
						    <thead>
						        <tr>
						            <th>ID</th>
									<th>Address</th>
									<th>Method</th>
									<th>Amount</th>
									<th>Status</th>
									<th>Date</th>
						        </tr>
						    </thead>
						    <tbody>
						        <?php
						      
						       
						    $allReqs = mysqli_query($conn, "SELECT * FROM seller_reqs WHERE `seller`='$seller' AND NOT `status`='0' ORDER BY id;");
                            while($row = mysqli_fetch_array($allReqs)) { 
                              echo '<tr>
                                        <td>'.$row['id'].'</td>
                                        <td>'.$row['addy'].'</td>
                                        <td>'.$row['method'].'</td>
                                        <td>'.$row['amount'].'</td>
                                        <td>';
                                        if($row['status'] == '1'){
                                            echo '<span style="color:green">Processed</span>';
                                        }else{
                                            echo '<span style="color:red">Refused</span>';
                                        }
                                        
                                        echo '</td>
                                        <td>'.$row['created_at'].'</td>
                                    </tr>
                                ';
			                    
			                    
                            }
						        
						        ?>

						    </tbody>
					
				
</table></div></div></div>


    </div>
    
    
    <?php
}else{
    

?>

<div id="main">		            
 <div class="new-box">
      <div class="card-header">
                   <h4 class="card-title">Request a payout:</h4>
      </div>
            <form method="POST" style="width: 100%;">
                <?php
                
                if(!empty($error)){
                    echo '<span style="color:red">'.$error.'</span>';
                }
                
                ?>

                <div class="form-sec">
                    <div class="form-group">
                        <label>Address:</label>
                        <input required="" name="addy" placeholder="BTC Address">
                    </div>

                    <div class="form-group">
                        <label>Amount:</label>
                        <input type="number" step="any" min="5" max="<?php echo number_format($seller_balance, 2, '.', ''); ?>" required="" name="amount" placeholder="(30 - <?php echo number_format($seller_balance, 2, '.', ''); ?>)" class="form-control">
                        <small>Min: 30 - Max: <?php echo number_format($seller_balance, 2, '.', ''); ?></small>
                    </div>
                    <div class="form-group">
                        <label>Method</label>
                        <select name="method" class="form-control" required="">
                            <option value="BTC">BTC</option>>
                        </select>
                    </div>


                </div>
                
                  
                <br>
                  <input name="btnSearch" type="submit" class="btn btn-normal" id="btnSearch" value="SUBMIT" style="margin: auto;display: block;">
     
              </form>
    </div>
    
    <div id="balance">
					<div class="section_content_deposit">
					    <a href="seller_dashboard.php?history" class="btn btn-normal" value="SUBMIT" style="float: right;">HISTORY</a>
					    <div class="page-title">Active Requests</div>

						<br>
						<table>
						    <thead>
						        <tr>
						            <th>ID</th>
									<th>Address</th>
									<th>Method</th>
									<th>Amount</th>
									<th>Date</th>
						        </tr>
						    </thead>
						    <tbody>
						        <?php
						      
						       
						    $allReqs = mysqli_query($conn, "SELECT * FROM seller_reqs WHERE `seller`='$seller' AND `status`='0' ORDER BY id;");
                            while($row = mysqli_fetch_array($allReqs)) { 
                              echo '<tr>
                                        <td>'.$row['id'].'</td>
                                        <td>'.$row['addy'].'</td>
                                        <td>'.$row['method'].'</td>
                                        <td>'.$row['amount'].'</td>
                                        <td>'.$row['created_at'].'</td>
                                    </tr>
                                ';
			                    
			                    
                            }
						        
						        ?>

						    </tbody>
					
				
</table></div></div></div>


    </div>
    <?php
    }

?>
    
        <style>
    

    input,select{
        background: rgb(34 40 49);
        border: none;
        border-radius: 5px;
        outline: none;
        padding: 10px;
        color: white;
        font-size: 13px;
        margin: 10px;
        margin-left: 0px;
        min-width: 200px;
    }

    .form-group{
        display: inline-flex;
        flex-direction: column;
        width: 100%;
        margin: 10px;
    }
    .form-sec{
        flex-direction: column;
        display: flex;
        width: 100%;
    }
    </style>