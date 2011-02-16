<?php
require("./header.php");
if ($checkLogin) {

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
										<strong>Status</strong>
									</td>
								</tr>
								<?php
								
								$result = $conn->query("SELECT * FROM `seller_reqs` WHERE NOT `status`='0';");
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
    									<td class="centered">';
    									    if($row['status'] == '1'){
    									        echo '<span style="color:green;">Accepted</span>';
    									    }else{
    									        echo '<span style="color:red;">Refused</span>';
    									    }
    									echo '

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