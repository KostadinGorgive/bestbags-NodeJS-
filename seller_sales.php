<?php
require("./seller_check.php");


require("./seller_nav.php");

$seller = $_SESSION["user_id"];


?>


<div id="main">		            
					<link rel="stylesheet" type="text/css" href="./admincp/style/main_admin.css">
					<div id="balance">
					<div class="section_content_deposit">
					    <div class="page-title">My Cards</div>

						<br>
						<table>
						    <thead>
						        <tr>
						            <th>Database</th>
						            <th>Buyer</th>
									<th>CARD NUMBER</th>
									<th>NAME</th>
									<th>COUNTRY</th>
									<th>STATE</th>
									<th>CITY</th>
									<th>ZIP</th>
									<th>PRICE</th>
						        </tr>
						    </thead>
						    <tbody>
						        <?php
						      
						       
						    $allCard = mysqli_query($conn, "SELECT *, AES_DECRYPT(card_number, '".strval(DB_ENCRYPT_PASS)."') AS card_number_de, AES_DECRYPT(card_fullinfo, '".strval(DB_ENCRYPT_PASS)."') AS card_fullinfo_de FROM cards WHERE `seller`='$seller' AND NOT `card_userid`='0' ORDER BY db;");
                            while($row = mysqli_fetch_array($allCard)) { 
                                $row['card_number'] = stringDec($row['card_number']);
                                echo '<tr>
                                <td>'.$row['db'].'</td>
                                <td>'.getUserData($row['card_userid'], "user_name", $conn).'</td>
                                <td>'.$row['card_number_de'].'</td>
                                <td>'.$row['card_name'].'</td>
                                <td>'.$row['card_country'].'</td>
                                <td>'.$row['card_state'].'</td>
                                <td>'.$row['card_city'].'</td>
                                <td>'.$row['card_zip'].'</td> 
                                <td>'.round(floatval(($row['card_price'] * 75) / 100),2).'</td>
                                </tr>
                                ';
			                    
			                    
                            }
						        
						        ?>

						    </tbody>
					
				
</table></div></div></div>



<style>
    td.edit{
        display: flex;
    justify-content: space-around;
    }
    
    input.edit{
            width: 50px;
    background: #1c2128;
    border: 1px solid #9a3aff;
    border-radius: 4px;
    outline: none;
    color: white;
    padding: 3px;
    margin-right: 6px;
    }
    
    button.check{
        color: white;
    background: none;
    border: none;
    outline: none;
    font-size: 15px;
    }
    
</style>