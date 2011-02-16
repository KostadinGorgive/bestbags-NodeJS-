<?php

require("./seller_check.php");


    $seller = $_SESSION["user_id"];



require("./seller_nav.php");



?>
<div id="main">		            
 <div class="new-box">
      <div class="card-header">
          <?php
          
          if($_SERVER['REQUEST_METHOD'] == 'POST'){
    

            $accetped = 0;
            $refused = 0;
            $card = addslashes($_POST['card'] );
            $explodeLine = explode("\n", $card);
            
            

            $card_database = mysqli_real_escape_string($conn, $_POST['db_type']);
                $query = mysqli_query($conn, "SELECT * FROM `seller_dbs` WHERE `name`='$card_database' AND `seller`='$seller';");
                if(mysqli_num_rows($query) == 0){
                    $error = "Wrong Database";
                }


        
            if(count($explodeLine) < 50){
                $error = "Minimum 50 cards.";
                
            }
            $split = $_POST['spliter'];
            
            if(empty($error)){
                
            foreach ($explodeLine as $line) {
               $card = explode($split, $line);
                $card_fullinfo = $line;
                
               $card_price   = round(floatval(str_replace(' ', '_', mysqli_real_escape_string($conn, $_POST['price']))), 2);
               $card_number      = str_replace(' ', '_', mysqli_real_escape_string($conn, $card[$_POST['number_pos']-1]));
               $card_month      = str_replace(' ', '_', mysqli_real_escape_string($conn, $card[$_POST['month_pos']-1]));
               $card_year     = str_replace(' ', '_', mysqli_real_escape_string($conn, $card[$_POST['year_pos']-1]));
               $card_cvv    = str_replace(' ', '_', mysqli_real_escape_string($conn, $card[$_POST['cvv_pos']-1]));
               
               if(strlen($card_year) == 2){
                   $card_year = '20'.$card_year;
               }
               
               if($_POST['name_pos'] == '-'){
                $card_name     = '-';
               }else{
                $card_name     = str_replace(' ', '_', mysqli_real_escape_string($conn, $card[$_POST['name_pos']-1]));
               }
        
               if($_POST['city_pos'] == '-'){
                $card_city     = '-';
               }else{
                $card_city    = str_replace(' ', '_', mysqli_real_escape_string($conn, $card[$_POST['city_pos']-1]));
               }
        
               if($_POST['state_pos'] == '-'){
                $card_state     = '-';
               }else{
                $card_state    = str_replace(' ', '_', mysqli_real_escape_string($conn, $card[$_POST['state_pos']-1]));
               }
        
               if($_POST['zip_pos'] == '-'){
                $card_zip     = '-';
               }else{
                $card_zip    = str_replace(' ', '_', mysqli_real_escape_string($conn, $card[$_POST['zip_pos']-1]));
               }
        
               
               
               
               if($_POST['country_pos'] == '-'){
                $card_country     = '-';
               }else{
                $card_country      = str_replace(' ', '_', mysqli_real_escape_string($conn, $card[$_POST['country_pos']-1]));
               }
        
               if($_POST['phone_pos'] == '-'){
                $card_phone     = '-';
               }else{
                $card_phone    = str_replace(' ', '_', mysqli_real_escape_string($conn, $card[$_POST['phone_pos']-1]));
               }
        
               if($_POST['ssn_pos'] == '-'){
                $card_ssn     = '-';
               }else{
                $card_ssn    = str_replace(' ', '_', mysqli_real_escape_string($conn, $card[$_POST['ssn_pos']-1]));
               }
        
               if($_POST['dob_pos'] == '-'){
                $card_dob     = '-';
               }else{
                $card_dob    = str_replace(' ', '_', mysqli_real_escape_string($conn, $card[$_POST['dob_pos']-1]));
               }
        
               
               
               
               $refund = intval($_POST['refundable']);
               
        
        
        
                $card_bin = $card_number[0].$card_number[1].$card_number[2].$card_number[3].$card_number[4].$card_number[5];
        
                if(empty($card_name)){
                    $card_name = '-';
                }
                
                if(empty($card_city)){
                    $card_city = '-';
                }
                
                if(empty($card_state)){
                    $card_state = '-';
                }
                
                if(empty($card_zip)){
                    $card_zip = '-';
                }
                
                if(empty($card_country)){
                    $card_country = '-';
                }
                
                if(empty($card_phone)){
                    $card_phone = '-';
                }
                
                if(empty($card_ssn)){
                    $card_ssn = '-';
                }
                
                if(empty($card_dob)){
                    $card_dob = '-';
                }
        
                $error = "";
                if(empty($card_price)){
                    $error = 'Emtpy Price Field';
                }
        
                if(empty($card_number)){
                    $error = 'Emtpy Number Field';
                }
        
                if(empty($card_month)){
                    $error = 'Emtpy Exp Month Field';
                }
        
                if(empty($card_year)){
                    $error = 'Emtpy Exp Year Field';
                }
        
                if(empty($card_cvv)){
                    $error = 'Emtpy CVV Field';
                }
        
                if(empty($card_database)){
                    $error = 'Emtpy DB Field';
                }
        
                if($card_price > 1 && $card_price < 100){
        
                }else{
                    $error = 'Price Out Of Range (1-100)';
                }

               if(empty($error)){
                
                $card_number = "AES_ENCRYPT('".$card_number."', '".strval(DB_ENCRYPT_PASS)."')";
                $card_fullinfo = "AES_ENCRYPT('".$card_fullinfo."', '".strval(DB_ENCRYPT_PASS)."')";
        
        
                  $sql = "INSERT INTO `cards`
        (`seller`, `card_price`, `card_number`, `card_bin`, `card_month`, `card_year`, `card_cvv`, `card_name`, `card_city`, `card_state`, `card_zip`, `card_country`, `card_phone`, `card_ssn`, `card_dob`, `db`, `card_check`, `card_fullinfo`, `card_status`, `card_refund`) VALUES 
        ('$seller','$card_price', ".$card_number." , '$card_bin','$card_month','$card_year','$card_cvv','$card_name','$card_city','$card_state','$card_zip','$card_country','$card_phone','$card_ssn','$card_dob','$card_database', '0', ".$card_fullinfo." , '0', '$refund')";
                  if ($stmt = $conn->prepare($sql)) {
                      // Bind variables to the prepared statement as parameters
                      // Attempt to execute the prepared statement
                      if ($stmt->execute()) {
                        echo '<span style="color:green;">'.$line.' => ACCEPTED</span><br>';
                        $accetped++;
        
                      } else {
                        echo '<span style="color:red;">'.$line.' => Duplicated</span><br>';
                      }
                      // Close statement
                      $stmt->close();
                  }else {
                          echo '<span style="color:red;">'.$line.' => Duplicated</span><br>';
                      }
        
               }else{
                    echo '<span style="color:red;">'.$line.' => '.$error.'</span><br>';
               }
            }
            
          }else{
              echo '<span style="color:red;">'.$error.'</span><br>';
          }
            if($accetped > 49){
            $title = "Database: <span style=\"color:red;\">".$card_database."</span> UPDATE";
            $content = "Added ".$accetped."x card to <a style=\"color:red;\" href=cards.php?db=".$card_database."\">".urldecode($card_database)."</a>";
            $time = time();
            $result = mysqli_query($conn, "INSERT INTO `news`( `news_title`, `news_content`, `news_author`, `news_time`) VALUES ('$title','$content','1','$time');");
            }
               
            
        }

          ?>
         <h4 class="card-title">Add Cards</h4>
      </div>
            <form method="POST" style="width: 100%;">
                  <textarea name="card"  class="form-control" rows="4" id="comment" required=""></textarea>

                <label>Positions:</label><br>
                <div class="form-sec">
                    <div class="form-group">
                        <label>Spliter:</label>
                        <input required="" name="spliter" value="|">
                    </div>
                    <div class="form-group">
                        <label>Card Number:</label>
                        <select name="number_pos">
                            <option selected value="-"> </option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Exp Month:</label>
                        <select name="month_pos">
                            <option selected value="-"> </option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Exp Year:</label>
                        <select name="year_pos">
                            <option selected value="-"> </option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Card CVV:</label>
                        <select name="cvv_pos">
                            <option selected value="-"> </option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Name:</label>
                        <select name="name_pos">
                            <option selected value="-"> </option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                        </select>
                    </div>


                    <div class="form-group">
                    <label>Address:</label>
                        <select name="addy_pos">
                            <option selected value="-"> </option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>City:</label>
                        <select name="city_pos">
                            <option selected value="-"> </option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>State:</label>
                        <select name="state_pos">
                            <option selected value="-"> </option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Zip Code:</label>
                        <select name="zip_pos">
                            <option selected value="-"> </option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Country:</label>
                        <select name="country_pos">
                            <option selected value="-"> </option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Phone:</label>
                        <select name="phone_pos">
                            <option selected value="-"> </option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>SSN:</label>
                        <select name="ssn_pos">
                            <option selected value="-"> </option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>DOB:</label>
                        <select name="dob_pos">
                            <option selected value="-"> </option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                        </select>
                    </div>





                </div>
                <label>Options:</label><br>
                <div class="form-sec">
                    <div class="form-group">
                        <label >Card Price:</label>
                        <input required name="price" placeholder="price" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Can be refunded?</label>
                        <select name="refundable" class="form-control" required="">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Database:</label>
                        <select name="db_type" class="form-control" required="">
                            <?php
                                $allReqs = mysqli_query($conn, "SELECT * FROM seller_dbs WHERE `seller`='$seller' ORDER BY id;");
                                while($row = mysqli_fetch_array($allReqs)) { 
                                    echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
                                }

                            
                            ?>
                        </select>
                    </div>

                </div>
                
                  
                <br>
                  <input name="btnSearch" type="submit" class="btn btn-normal" id="btnSearch" value="UPLOAD">
     
              </form>
    </div>
    </div>
    
    
    
    <style>
    
    textarea{
    background: rgb(34 40 49);
    border: none;
    border-radius: 5px;
    width: 100%;
    min-height: 231px;
    outline: none;
    padding: 20px;
    color: white;
    font-size: 13px;
    overflow: auto;
    margin: 5px 0px 15px;
        
    }
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
    width: 200px;
    margin: 10px;
    }
    </style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>




