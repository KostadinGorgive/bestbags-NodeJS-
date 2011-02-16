<?php
require("./seller_check.php");


require("./seller_nav.php");

$seller = $_SESSION["user_id"];





if(isset($_GET['act'])){
    if($_GET['act'] == 'edit'){
        
        $new_price = round(floatval(mysqli_real_escape_string($conn, $_GET['newprice'])),2);
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        
        $editCard = mysqli_query($conn, "SELECT * FROM `cards` WHERE `seller`='$seller' AND `card_userid`='0' AND `card_id`='$id';");
        $row = mysqli_fetch_array($editCard);
        if(mysqli_num_rows($editCard) > 0 && $row['seller'] == $seller){
            
            $card_database = $row['db'];
            $result = mysqli_query($conn, "UPDATE `cards` SET `card_price`='$new_price' WHERE `seller`='$seller' AND `card_userid`='0' AND `card_id`='$id';");
           if($result){
               
            
                header('location: seller_cards.php?success');
            }
        }
        
    }elseif($_GET['act'] == 'del'){
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        
        $editCard = mysqli_query($conn, "SELECT * FROM `cards` WHERE `seller`='$seller' AND `card_userid`='0' AND `card_id`='$id';");
        $row = mysqli_fetch_array($editCard);
        if(mysqli_num_rows($editCard) > 0 && $row['seller'] == $seller){
            
            
            $result = mysqli_query($conn, "DELETE FROM `cards` WHERE `seller`='$seller' AND `card_userid`='0' AND `card_id`='$id';");
            if($result){
                header('location: seller_cards.php?success');
            }
        }
        
        
    }
    
    
    
}
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
									<th>CARD NUMBER</th>
									<th>NAME</th>
									<th>COUNTRY</th>
									<th>STATE</th>
									<th>CITY</th>
									<th>ZIP</th>
									<th>Refundable</th>
									<th>PRICE</th>
									<th>Actions</th>
						        </tr>
						    </thead>
						    <tbody>
						        <?php
						      
						       
						    $allCard = mysqli_query($conn, "SELECT *, AES_DECRYPT(card_number, '".strval(DB_ENCRYPT_PASS)."') AS card_number_de, AES_DECRYPT(card_fullinfo, '".strval(DB_ENCRYPT_PASS)."') AS card_fullinfo_de FROM cards WHERE `seller`='$seller' AND `card_userid`='0' ORDER BY db;");
                            while($row = mysqli_fetch_array($allCard)) { 
                                $row['card_number'] = stringDec($row['card_number']);
                                echo '<tr>
                                <td>'.$row['db'].'</td>
                                <td>'.$row['card_number_de'].'</td>
                                <td>'.$row['card_name'].'</td>
                                <td>'.$row['card_country'].'</td>
                                <td>'.$row['card_state'].'</td>
                                <td>'.$row['card_city'].'</td>
                                <td>'.$row['card_zip'].'</td>
                                <td>';
                                
                                if($row['card_refund'] == '1'){
                                    echo 'Yes';
                                }else{
                                    echo 'No';
                                }
                                
                                echo '</td>
                                <td><form style="display: none;" id="'.$row['card_id'].'form" method="get" action="seller_cards.php">
                                
                                <input type="hidden" name="id" value="'.$row['card_id'].'">
                                <input type="hidden" name="act" value="edit">
                                <input name="newprice" class="edit" value="'.$row['card_price'].'"><button class="check"><i class="fa fa-check-circle"></i></button></form>
                                
                                <span id="'.$row['card_id'].'ogprice">'.$row['card_price'].'</span></td>
                                <td class="edit"> 
                                
                                <a id="'.$row['card_id'].'editbtn" onclick="editVal(\''.$row['card_id'].'\')"><i class="fa fa-edit"></i></a> 
                                
                                </tr>
                                ';
			                    
			                    
                            }
						        
						        ?>

						    </tbody>
					
				
</table></div></div></div>

<script>

function editVal(val){
    $('#' + val + 'form').show();
     $('#' + val + 'ogprice').hide();
     $('#' + val + 'editbtn').hide();
}

</script>

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