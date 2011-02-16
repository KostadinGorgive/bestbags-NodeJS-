<?php

require("./seller_check.php");

require("./seller_nav.php");

$seller = $_SESSION["user_id"];
$error = "";

if(isset($_GET['del'])){
    $_GET['del'] = urldecode($_GET['del']);
    $dbname = mysqli_real_escape_string($conn, $_GET['del']);
    $sql = "DELETE FROM `cards` WHERE `seller`='$seller' AND `card_userid`='0' AND `db`='$dbname';";
    $query = mysqli_query($conn, $sql);
    
    $query = mysqli_query($conn, "DELETE FROM `seller_dbs` WHERE `name`='$dbname' AND `seller`='$seller';");
    
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $dbname = str_replace(' ', '_', mysqli_real_escape_string($conn, $_POST['database_name']));
    
    $query = mysqli_query($conn, "SELECT * FROM `seller_dbs` WHERE `name`='$dbname';");
    echo mysqli_num_rows($query);
    if(mysqli_num_rows($query) == 0){


        $query = mysqli_query($conn, "INSERT INTO `seller_dbs`(`seller`, `name`) VALUES ('$seller','$dbname');");
        

    }else{
        $error = "Database name already used.";
    }
    
    
}

?>
    


<div id="main">		            
 <div class="new-box">
      <div class="card-header">
                   <h4 class="card-title">Create new Database:</h4>
      </div>
            <form method="POST" style="width: 100%;">
                <?php
                
                if(!empty($error)){
                    echo '<span style="color:red">'.$error.'</span>';
                }
                
                ?>

                <div class="form-sec">
                    <div class="form-group">
                        <label>Name:</label>
                        <input required="" name="database_name" placeholder="Database Name">
                    </div>


                </div>
                
                  
                <br>
                  <input name="btnSearch" type="submit" class="btn btn-normal" id="btnSearch" value="SUBMIT" style="margin: auto;display: block;">
     
              </form>
    </div>
    
    <div id="balance">
					<div class="section_content_deposit">
					    <div class="page-title">My Databases</div>

						<br>
						<table>
						    <thead>
						        <tr>
									<th>Name</th>
									<th>Date</th>
						        </tr>
						    </thead>
						    <tbody>
						        <?php
						      
						       
						    $allReqs = mysqli_query($conn, "SELECT * FROM seller_dbs WHERE `seller`='$seller' ORDER BY id;");
                            while($row = mysqli_fetch_array($allReqs)) { 
                              echo '<tr>
                                        <td>'.$row['name'].'</td>
                                        <td>'.$row['created_at'].'</td>
                                    </tr>
                                ';
			                    
			                    
                            }
						        
						        ?>

						    </tbody>
					
				
</table></div></div></div>


    </div>

    
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