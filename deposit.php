<?php

require("./header.php");


function generateAddress(){
    $apikey = "CIK62alL1slvBuMg8MiZCmXahoOYESIhaF2aaEk1ZwY";
    $url = "https://www.blockonomics.co/api/";
    $options = array( 
        'http' => array(
            'header'  => 'Authorization: Bearer '.$apikey,
            'method'  => 'POST',
            'content' => '',
            'ignore_errors' => true
        )   
    );  
    
    $context = stream_context_create($options);
    $contents = file_get_contents($url."new_address", false, $context);
    $object = json_decode($contents);
    
    // Check if address was generated successfully
    if (isset($object->address)) {
      $address = $object->address;
    } else {
      // Show any possible errors
      $address = $http_response_header[0]."\n".$contents;
    }
    return $address;
}

if ($checkLogin) {
    
        $id = $_SESSION["user_id"];
        $user_name = $_SESSION["user_name"];
        
    	$count_sql = "SELECT count(*) FROM `addrs` WHERE `user_id` = '$id'";
    	$count_result = $db->query_first($count_sql);
		$num_rows = $count_result["count(*)"];
    
    
		$sql = "SELECT * FROM `addrs` WHERE `user_id`='{$id}';";

		$addr_query = $db->query_first($sql);

		
		 if ($num_rows == 0) {
		    $address = generateAddress();
		    $addr_row['user_id']= $id;
		    $addr_row['addr']= $address;
		    $addr_row['user_name']= $user_name;
			if($db->query_insert(addrs, $addr_row)) {
                echo '<div class="new-box">New Address Generated</div>';
			}

		} else {
			$address = $addr_query['addr'];
		}
				
        
    
?>		            
					<link rel="stylesheet" type="text/css" href="./admincp/style/main_admin.css" />
					<div id="balance">
					<div class="section_content_deposit">
					    <?php
	if ($user_info["user_balance"] > -1) {
?>
						<div class="page-title">DEPOSIT MONEY</div>

<?php
	}
?>

					
							<?php
	if ($user_info["user_balance"] <= -1) {
?>
						<div class="page-title">ACTIVATE MY ACCOUNT</div>

<?php
	}
?>
						<div class="new-box">
							<span class="red"><img src="./images/bitcoin.png" width="115px" height="38px"></span>
								<p>Bitcoin is a very fast way to fund/add-balance to your Account!</p>

							<?php
	if ($user_info["user_balance"] > -1) {
?>
							<p>Instantly add balance, And purchase cards right away!!</p>
							<p>This is your unique address, send any amount you want and it will be shown below under Payments section.</p>
<?php
	}
?>
					
							<?php
	if ($user_info["user_balance"] <= -1) {
?>
<p style="font-size:14px;color:#f72b50;">Please send an amount of 40$ to your unique bitcoin adress below to activate your account instantly!</p>	
<p style="font-size:14px;color:#f72b50;"></p>				

	<div id="balance_notify" class="centered red bold">
				</div>
<?php
	}
?>
                            
                            <p class="addy"> <?php echo $address; ?></p>
                            <img id="tiger" style="display: none;" src="https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=<?php echo $address; ?>&choe=UTF-8"> 
                            <p></p>
                             </br>
                            <center><a style="" class="btn btn-del" id="toggle">Show QR CODE</a></center>
                                                              </br>
                                <script type="text/javascript">
$('#toggle').click(function() {
    $('#tiger').toggle();
});
    </script>
						</div>
						<br>
						<table>
						    <thead>
						        <tr>
						            <th>ID</th>
						            <th>TXID</th>
						            <th>Value</th>
						            <th>Status</th>
						            <th>Created At</th>
						        </tr>
						    </thead>
						    <tbody>
						        <?php

						        $showinvoices = mysqli_query($conn, "SELECT * FROM `n_payments` WHERE `user_id` = '$id';");
						        if(mysqli_num_rows($showinvoices) > 0){
                                    while($row_invoice = mysqli_fetch_array($showinvoices)){
                                        echo '
                                    <tr>
    						            <td>'.$row_invoice['id'].'</td>
    						            <td>'.$row_invoice['txid'].'</td>
    						            <td>'.$row_invoice['usd_value'].'$</td>
    						            <td>';
    						            
    						            if($row_invoice['status'] == 0){
    						                echo '<span class="tag-del">UNCONFIRMED</span>';
    						            }elseif($row_invoice['status'] == 1){
    						                echo '<span class="tag-del">PARTIALLY CONFIRMED</span>';
    						            }elseif($row_invoice['status'] == 2){
    						                echo '<span class="tag-success">CONFIRMED</span>';
    						            }else{
    						                echo '<span class="tag-del">ERROR</span>';
    						            }
    						            
    						            echo '</td>
    						            <td>'.date("j M, g:i a", strtotime($row_invoice['created_at'])).'</td>
    						        </tr>
                                        ';
                                    }
						        }else{
						            echo '<tr>
									<td colspan="3" class="red bold centered">
										No record found.
									</td>
								</tr>';
						        }
						        
						        ?>

						    </tbody>
					</div>
				</div>
<?php
}
else {
	require("./minilogin.php");
}
require("./footer.php");
?>
<style>
p.addy{
    width: 100%;
    text-align: center;
    background: #222831;
    padding: 20px;
    color: white;
    font-weight: 600;
    border-radius: 15px;
    }
    
img {
  display: block;
  margin-left: auto;
  margin-right: auto;
}
</style>