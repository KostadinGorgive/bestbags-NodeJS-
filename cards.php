<?php

require("./header.php");
if ($checkLogin) {



     $params = "?";
     foreach($_GET as $key => $value){
        if($key != 'page'){
           $temp = $key.'='.$value.'&';
           $params = $params.$temp;
        }
     }
                     
  $cpage = $_GET['page'];
      if(empty($cpage) || $cpage == 0 || $cpage == '0'){
         $cpage = 1;
      }
      if (!isset ($cpage) ) {  
         $page = 1;  
      } else {  
         $page = $cpage;  
      }  

      $results_per_page = 40;  
      $page_first_result = ($page-1) * $results_per_page;  

      $countryArr = array();
      $cityArr    = array();
      $stateArr   = array();

      $binArr   = array();
      $dbArr    = array();
      $zipArr    = array();
      $bankArr    = array();
      $cardLevelArr    = array();

      $sqlcons = "";
      if(isset($_GET['country']) && !empty($_GET['country'])){
         $countryGet   = mysqli_real_escape_string($conn, $_GET['country']);
         $sqlcons = $sqlcons."AND card_country = '".$countryGet."' ";
      }
      if(isset($_GET['city']) && !empty($_GET['city'])){
         $cityyGet   = mysqli_real_escape_string($conn, $_GET['city']);
         $sqlcons = $sqlcons."AND card_city = '".$cityyGet."' ";
      }
      if(isset($_GET['state']) && !empty($_GET['state'])){
         $stateGet   = mysqli_real_escape_string($conn, $_GET['state']);
         $sqlcons = $sqlcons."AND card_state = '".$stateGet."' ";
      }
      if(isset($_GET['bin']) && !empty($_GET['bin'])){
         $binGet   = mysqli_real_escape_string($conn, $_GET['bin']);
         $sqlcons = $sqlcons."AND (card_bin LIKE '%".$binGet."%') ";
      }
      if(isset($_GET['db']) && !empty($_GET['db'])){
         $dbGet   = mysqli_real_escape_string($conn, $_GET['db']);
         $sqlcons = $sqlcons."AND db = '".$dbGet."' ";
      }
      if(isset($_GET['zip']) && !empty($_GET['zip'])){
         $zipGet   = mysqli_real_escape_string($conn, $_GET['zip']);
         $sqlcons = $sqlcons."AND card_zip = '".$zipGet."' ";
      }
      if(isset($_GET['lowerAmount']) && !empty($_GET['lowerAmount'])){
         $lowerAmountGet   = mysqli_real_escape_string($conn, $_GET['lowerAmount']);
         $sqlcons = $sqlcons."AND card_price >= '".$lowerAmountGet."' ";
      }
      if(isset($_GET['upperAmount']) && !empty($_GET['upperAmount'])){
         $upperAmountGet   = mysqli_real_escape_string($conn, $_GET['upperAmount']);
         $sqlcons = $sqlcons."AND card_price <= '".$upperAmountGet."' ";
      }
      if (!empty($_GET['bankName']) || !empty($_GET['cardLevel'])) {
            $sqlconsRef = '';
          if(isset($_GET['bankName']) && !empty($_GET['bankName'])){
             $bankNameGet   = mysqli_real_escape_string($conn, $_GET['bankName']);
             $sqlconsRef = $sqlconsRef."AND card_price = '".$bankNameGet."' ";
          }
          if(isset($_GET['cardLevel']) && !empty($_GET['cardLevel'])){
             $cardLevelGet   = mysqli_real_escape_string($conn, $_GET['cardLevel']);
             $sqlconsRef = $sqlconsRef."AND card_price = '".$cardLevelGet."' ";
          }
          $selectData = "SELECT * FROM `bins` WHERE `blanked`=0 ".$sqlconsRef.";";
          $querDataRef = mysqli_query($conn, $selectData);
          if(mysqli_num_rows($querDataRef) > 0){
            $bin = '';
            while($row = mysqli_fetch_assoc($querDataRef)){
                $fetchBin = $row['card_bin'];
                $bin = $bin."AND `card_bin`='".$fetchBin."' ";
            }
            $resultSqlSelect = mysqli_query($conn, "SELECT * FROM cards WHERE card_status = '".STATUS_DEFAULT."' ".$bin." AND `card_userid` = '0' ".$sqlcons." ORDER BY card_id DESC LIMIT " . $page_first_result .";");
          }
      }else{        
        if(isset($_GET['page']) && !empty($_GET['page'])){
            $resultSqlSelect = mysqli_query($conn, "SELECT * FROM cards WHERE card_status = '".STATUS_DEFAULT."' AND `card_userid` = '0' ".$sqlcons." ORDER BY card_id DESC LIMIT " . $page_first_result .','.$results_per_page.";");
        }else{
            $resultSqlSelect = mysqli_query($conn, "SELECT * FROM cards WHERE card_status = '".STATUS_DEFAULT."' AND `card_userid` = '0' ".$sqlcons." ORDER BY card_id DESC LIMIT " . $page_first_result .";");
        }
      }

      $sql = "SELECT * FROM cards WHERE card_status = '".STATUS_DEFAULT."' AND `card_userid` = '0' ORDER BY card_id DESC;";
      $result = mysqli_query($conn, $sql);
      $number_of_result = mysqli_num_rows($result);
      while ($cardAllRow = mysqli_fetch_array($result)) {
         $country = $cardAllRow['card_country'];
         $city = $cardAllRow['card_city'];
         $state = $cardAllRow['card_state'];
         $db = $cardAllRow['db'];
         $zip = $cardAllRow['card_zip'];

         if (!in_array($country, $countryArr) && !empty($country)){
            array_push($countryArr, $country); 
         }

         if (!in_array($city, $cityArr) && !empty($city)){
            array_push($cityArr, $city); 
         }

         if (!in_array($state, $stateArr) && !empty($state)){
            array_push($stateArr, $state); 
         }

         if (!in_array($db, $dbArr) && !empty($db)){
            array_push($dbArr, $db); 
         }

         if (!in_array($zip, $zipArr) && !empty($zip)){
            array_push($zipArr, $zip); 
         }
      }

      $sqlBin = "SELECT DISTINCT * FROM bins ORDER BY card_bin ASC LIMIT 20000";
      $resultBin = mysqli_query($conn, $sqlBin);
      $number_of_result_bin = mysqli_num_rows($resultBin);
      
    while ($cardAllRowBin = mysqli_fetch_array($resultBin)) {
                
         $bank = $cardAllRowBin['card_bank'];
         $level = $cardAllRowBin['card_level'];

         if (!in_array($bank, $bankArr) && !empty($bank)){
            array_push($bankArr, $bank); 
         }
         if (!in_array($level, $cardLevelArr) && !empty($level)){
            array_push($cardLevelArr, $level); 
         }
      }
      $number_of_page = ceil ($number_of_result / $results_per_page);  
                      
                      

?>

<style>
    .price-slider {
  width: 145px;
  margin: auto;
  text-align: center;
  position: relative;
  height: 3.8em;
}
.price-slider svg,
.price-slider input[type=range] {
  position: absolute;
  left: 0;
  bottom: 0;
}
input[type=number] {
  border: 1px solid #ddd;
  text-align: center;
  font-size: 1.6em;
  -moz-appearance: textfield;
}
.price-slider input[type="number"] {
    font-size: 12px;
    width: fit-content;
    background: #191d22;
    border: none;
    color: #fff;
    outline: none;
}
input[type=number]::-webkit-outer-spin-button,
input[type=number]::-webkit-inner-spin-button {
  -webkit-appearance: none;
}
input[type=number]:invalid,
input[type=number]:out-of-range {
  border: 2px solid #e60023;
}
input[type=range] {
  -webkit-appearance: none;
  width: 100%;
}
input[type=range]:focus {
  outline: none;
}
input[type=range]:focus::-webkit-slider-runnable-track {
  background: #1da1f2;
}
input[type=range]:focus::-ms-fill-lower {
  background: #1da1f2;
}
input[type=range]:focus::-ms-fill-upper {
  background: #1da1f2;
}
input[type=range]::-webkit-slider-runnable-track {
  width: 100%;
  height: 5px;
  cursor: pointer;
  animate: 0.2s;
  background: #1da1f2;
  border-radius: 1px;
  box-shadow: none;
  border: 0;
}
input[type=range]::-webkit-slider-thumb {
  z-index: 2;
  position: relative;
  box-shadow: 0px 0px 0px #000;
  border: 1px solid #1da1f2;
  height: 18px;
  width: 18px;
  border-radius: 25px;
  background: #a1d0ff;
  cursor: pointer;
  -webkit-appearance: none;
  margin-top: -7px;
}
input[type=range]::-moz-range-track {
  width: 100%;
  height: 5px;
  cursor: pointer;
  animate: 0.2s;
  background: #1da1f2;
  border-radius: 1px;
  box-shadow: none;
  border: 0;
}
input[type=range]::-moz-range-thumb {
  z-index: 2;
  position: relative;
  box-shadow: 0px 0px 0px #000;
  border: 1px solid #1da1f2;
  height: 18px;
  width: 18px;
  border-radius: 25px;
  background: #a1d0ff;
  cursor: pointer;
}
input[type=range]::-ms-track {
  width: 100%;
  height: 5px;
  cursor: pointer;
  animate: 0.2s;
  background: transparent;
  border-color: transparent;
  color: transparent;
}
input[type=range]::-ms-fill-lower,
input[type=range]::-ms-fill-upper {
  background: #1da1f2;
  border-radius: 1px;
  box-shadow: none;
  border: 0;
}
input[type=range]::-ms-thumb {
  z-index: 2;
  position: relative;
  box-shadow: 0px 0px 0px #000;
  border: 1px solid #1da1f2;
  height: 18px;
  width: 18px;
  border-radius: 25px;
  background: #a1d0ff;
  cursor: pointer;
}
</style>
                <div id="check_history">
                    <div class="page-title">CARDS</div>
                    <div class="section_page_bar">

                    </div>
                    <div class="section_content">
                        
                                        <form action="cards.php" method="GET" id="cardBrandFilters">
                                            <input id="cardBrandFiltersInput" type="hidden" name="bin">
                                        </form>
                                <form id="searchForm" name="searchForm" method="GET" action="cards.php">
                                    <form name="addtocart" method="POST" action="./cart.php">

                                    <input type="hidden" name="stagnant" value="<?=$_GET["stagnant"]?>" />
                                    <div>
                                        <p style="color:white;font-size:14px;">CARD BRAND</p>
                                    <td>
                                            <a href='#' onclick="$('#cardBrandFiltersInput').val(3);$('#cardBrandFilters').submit();"><img src="./images/213753_american express_amex_card_cash_checkout_icon.png" class="iconcc" /></a>
                                            <a href='#' onclick="$('#cardBrandFiltersInput').val(4);$('#cardBrandFilters').submit();"><img src="./images/206684_visa_method_card_payment_icon.png" class="iconcc" /></a>
                                            <a href='#' onclick="$('#cardBrandFiltersInput').val(5);$('#cardBrandFilters').submit();"><img src="./images/213734_card_cash_checkout_mastercard_online shopping_icon.png" class="iconcc" /></a>
                                            <a href='#' onclick="$('#cardBrandFiltersInput').val(6);$('#cardBrandFilters').submit();"><img src="./images/206686_network_payment_discover_card_method_icon.png" class="iconcc" /></a>
                                        </td>
                                        </div>
                                    <label>
                                        BIN
                                        <input name="bin" placeholder="Enter Bin" type="text" class="input" id="txtBin" value="<?=$_GET["bin"]?>" size="12" maxlength="6">
                                    </label>


                                    <label>
                                    COUNTRY
                                    <select autofocus="autofocus" onfocus="this.select(All Countries)" name="country" class="input select-with-search" id="lstCountry">
                                        
                                                <option value="">All Countries</option>
                                                
                                                
                                            <?php
                                            
                                                foreach($countryArr as $value){
                                                  echo '<option'; if($value == $_GET['country']){echo ' SELECTED';} echo' value='.$value.'>'.$value.'   </option>';
                                                }
                                            ?>
                                            
                                            </select>
                                    </label>


                                    <label>
                                        STATE
                                        <select autofocus="autofocus" onfocus="this.select(All States)" name="state" placeholde="Select State" class="input select-with-search" id="lstState">
                                                <option value="">All States</option>
                                            <?php
                                                foreach($stateArr as $value){
                                                   echo '<option'; if($value == $_GET['state']){echo ' SELECTED';} echo' value='.$value.'>'.$value.'   </option>';
                                                }
                                            ?>
                                            </select>
                                    </label>

                                    <label>
                                            CITY
                                            <select name="city" class="input select-with-search" id="lstCity">
                                                <option value="">All Cities</option>
                                            <?php
                                                foreach($cityArr as $value){
                                                   echo '<option'; if($value == $_GET['city']){echo ' SELECTED';} echo' value='.$value.'>'.$value.'   </option>';
                                                }
                                            ?>
                                            </select>
                                    </label>
                                    
                                    
                                    
                                                                        <label>
                                            Database
                                            
                                            
                                            <select name="db" class="input select-with-search" id="">
                                                <option value="">All Databases</option>
                                            <?php
                                                foreach($dbArr as $value){
                                                   echo '<option'; if($value == $_GET['db']){echo ' SELECTED';} echo' value='.$value.'>'.$value.'   </option>';
                                                }
                                            ?>
                                            </select>
                                    </label>
                                     <label>
                                            ZIP
                                            <select name="zip" class="input select-with-search" id="zip">
                                                <option value="">All ZIP</option>
                                            <?php
                                                foreach($zipArr as $value){
                                                   echo '<option'; if($value == $_GET['zip']){echo ' SELECTED';} echo' value='.$value.'>'.$value.'   </option>';
                                                }
                                            ?>
                                            </select>
                                    </label>
                                    
                                    
                                    
                                    
                                    
                                    
                                     <label>
                                            Bank Name
                                            <select name="bankName" class="input select-with-search" id="bank">
                                                <option value="">All Bank</option>
                                            <?php
                                                foreach($bankArr as $value){
                                                   echo '<option'; if($value == $_GET['bankName']){echo ' SELECTED';} echo' value='.$value.'>'.$value.'   </option>';
                                                }
                                            ?>
                                            </select>
                                    </label>
                                     <label>
                                            Card Level
                                            <select name="cardLevel" class="input select-with-search" id="level">
                                                <option value="">All Card Level</option>
                                            <?php
                                                foreach($cardLevelArr as $value){
                                                   echo '<option'; if($value == $_GET['cardLevel']){echo ' SELECTED';} echo' value='.$value.'>'.$value.'   </option>';
                                                }
                                            ?>
                                            </select>
                                    </label>
                                    <label>
                                        <div class="price-slider"><span>
                                            <input name="lowerAmount" type="number" <?php if(isset($_GET['lowerAmount'])){ echo "value='".$_GET['lowerAmount']."'";}else{ echo "value='1'"; } ?> min="0" max="100"/>    to
                                            <input name="upperAmount" type="number" <?php if(isset($_GET['upperAmount'])){ echo "value='".$_GET['upperAmount']."'";}else{ echo "value='12'"; } ?> min="0" max="100"/></span>
                                        <input <?php if(isset($_GET['lowerAmount'])){ echo "value='".$_GET['lowerAmount']."'";}else{ echo "value='1'"; } ?> min="0" max="100" step="1" type="range"/>
                                        <input <?php if(isset($_GET['upperAmount'])){ echo "value='".$_GET['upperAmount']."'";}else{ echo "value='12'"; } ?> min="0" max="100" step="1" type="range"/>
                                        <svg width="100%" height="24">
                                            <line x1="4" y1="0" x2="300" y2="0" stroke="#fff" stroke-width="12" stroke-dasharray="1 8"></line>
                                        </svg>
                                        </div>
                                        <script>
                                            (function() {
                                        
                                        var parent = document.querySelector(".price-slider");
                                        if(!parent) return;
                                        
                                        var
                                            rangeS = parent.querySelectorAll("input[type=range]"),
                                            numberS = parent.querySelectorAll("input[type=number]");
                                        
                                        rangeS.forEach(function(el) {
                                            el.oninput = function() {
                                            var slide1 = parseFloat(rangeS[0].value),
                                                    slide2 = parseFloat(rangeS[1].value);
                                        
                                            if (slide1 > slide2) {
                                                [slide1, slide2] = [slide2, slide1];
                                            }
                                        
                                            numberS[0].value = slide1;
                                            numberS[1].value = slide2;
                                            }
                                        });
                                        
                                        numberS.forEach(function(el) {
                                            el.oninput = function() {
                                                var number1 = parseFloat(numberS[0].value),
                                                number2 = parseFloat(numberS[1].value);
                                                
                                            if (number1 > number2) {
                                                var tmp = number1;
                                                numberS[0].value = number2;
                                                numberS[1].value = tmp;
                                            }
                                        
                                            rangeS[0].value = number1;
                                            rangeS[1].value = number2;
                                        
                                            }
                                        });
                                        
                                        })();
                                        </script>

                                    
                                    
                                    </label>
                                    <label style="height: 55px;justify-content: flex-end;vertical-align: top;"><input name="btnSearch" type="submit" class="btn btn-normal" id="btnSearch" value="SEARCH">
                           </label>                        
                                        
                                        
                                    
                                </form>
                                <?php if(isset($_GET['error_response']) && !empty($_GET['error_response'])){ ?>
                                    <p style="color: red; text-align: center;"><?php echo $_GET['error_response']; ?></p>
                                <?php } ?>
                    </div>
                </div>
                <p></p>
                                <p></p>
                                                <p></p>
                                                                <p></p>
                                                                                <p></p>
                                                                                                <p></p>
                                            <div style="color: var(--white);display: flex;justify-content: right;align-items: right;">
                                            <span>
                     <a href="cards.php<?php echo $params; ?>page=1" class="firstorlast<?php if($cpage == 1){ echo ' current '; } ?>">1</a>
                     
                     <?php if($number_of_page == 1){ ?>

                     <?php }elseif($number_of_page == 2){ ?>
                        <a href="cards.php<?php echo $params; ?>page=2" class="paginate_button<?php if($cpage == 2){ echo ' current '; } ?>"">2</a>

                     <?php }elseif($number_of_page == 3){ ?>
                        <a href="cards.php<?php echo $params; ?>page=2" class="paginate_button<?php if($cpage == 2){ echo ' current '; } ?>"">2</a>
                        <a href="cards.php<?php echo $params; ?>page=3" class="paginate_button<?php if($cpage == 3){ echo ' current '; } ?>"">3</a>
                        
                     <?php }else{ ?>
                        <?php if($cpage == 1){ ?>
                           <a href="cards.php<?php echo $params; ?>page=2" class="paginate_button">2</a>
                           <a href="cards.php<?php echo $params; ?>page=3" class="paginate_button">3</a>
                           <a href="cards.php<?php echo $params; ?>page=4" class="paginate_button">4</a>

                        <?php }elseif($cpage == 2){ ?>

                           <a href="cards.php<?php echo $params; ?>page=2" class="paginate_button current">2</a>
                           <a href="cards.php<?php echo $params; ?>page=3" class="paginate_button">3</a>
                           <a href="cards.php<?php echo $params; ?>page=4" class="paginate_button">4</a>

                        <?php }elseif($cpage == $number_of_page){ ?>

                        <a href="cards.php<?php echo $params; ?>page=<?php echo $cpage-3; ?>" class="paginate_button"><?php echo $cpage-3; ?></a>
                        <a href="cards.php<?php echo $params; ?>page=<?php echo $cpage-2; ?>" class="paginate_button"><?php echo $cpage-2; ?></a>
                        <a href="cards.php<?php echo $params; ?>page=<?php echo $cpage-1; ?>" class="paginate_button"><?php echo $cpage-1; ?></a>

                        <?php }elseif($cpage == $number_of_page-1){ ?>

                        <a href="cards.php<?php echo $params; ?>page=<?php echo $cpage-2; ?>" class="paginate_button"><?php echo $cpage-2; ?></a>
                        <a href="cards.php<?php echo $params; ?>page=<?php echo $cpage-1; ?>" class="paginate_button"><?php echo $cpage-1; ?></a>
                        <a href="cards.php<?php echo $params; ?>page=<?php echo $cpage; ?>" class="paginate_button current"><?php echo $cpage; ?></a>

                        <?php }else{ ?>

                        <a href="cards.php<?php echo $params; ?>page=<?php echo $cpage-1; ?>" class="paginate_button"><?php echo $cpage-1; ?></a>
                        <a href="cards.php<?php echo $params; ?>page=<?php echo $cpage; ?>" class="paginate_button current"><?php echo $cpage; ?></a>
                        <a href="cards.php<?php echo $params; ?>page=<?php echo $cpage+1; ?>" class="paginate_button"><?php echo $cpage+1; ?></a>

                        <?php } ?>
                        <a href="cards.php<?php echo $params; ?>page=<?php echo $number_of_page; ?>" class="firstorlast<?php if($cpage == $number_of_page){ echo ' current '; } ?>" >LAST PAGE</a>
                           </br>
                               </br>
                     <?php } ?>
                  </span></div>
    <p></p>
                                <p></p>
                                                <p></p>
                                                                <p></p>
                                                                                <p></p>
                                                                                                <p></p>
                        <table class="content_table">
                        <form name="addtocart" method="POST" action="./cart.php">
                            <thead>
                                <tr>
                                    <th>BIN</th>
                                    <th>Database</th>
                                    <th>NAME</th>
                                    <th>COUNTRY</th>
                                    <th>STATE</th>
                                    <th>Refund</th>
                                    <th>Phone</th>
                                    <th>SSN</th>
                                    <th>DOB</th>
                                    <th>PRICE</th>
                                    <th><input class="checkbox_select" type="checkbox" name="selectAllCards" id="selectAllCards" onclick="checkAll(this.id, 'cards[]')" value=""></th>
                                    <th>ADD TO CART</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                
                                
                                $cardsNum = mysqli_num_rows($resultSqlSelect);
                                
                                
                                
    if ($cardsNum > 0) {
        
        
        while($row = mysqli_fetch_array($resultSqlSelect)) {
            $value=$row;
            $card_firstname = explode(" ", $value['card_name']);
            $card_firstname = $card_firstname[0];
?>

                                <tr class="formstyle">
                                
                                    <td class="centered">
                                    
                                        <span><?=$value['card_bin']?></span>
                                    </td>
                                    <td class="centered">
                                    
                                        <span><?php
                                            if(empty($value['db'])){
                                                echo '<span style="color:green;">MajorShop</span>';
                                            }else{
                                                echo $value['db'];
                                            }
                                            ?></span>
                                    </td>
                                    <td class="centered bold">
                                         <span><?=$card_firstname?></span>
                                    </td>
                                    <td class="centered bold">
                                                                <span><?=$value['card_country']?></span><br><span>City: <?=$value['card_city']?></span>
                                    </td>
                                    <td class="centered bold">
                                                                                 <span><?=$value['card_state']?></span><br><span>ZIP: <?=$value['card_zip']?></span>       
                                                        </td>

                                    <td class="centered bold">
                                            <span><?php
                                            if($value['card_refund'] == '0'){
                                                echo '<span style="color:red;">No</span>';
                                            }elseif($value['card_refund'] == '1'){
                                                echo '<span style="color:green;">Yes</span>';
                                            }
                                            ?></span>
                                    </td>
                                    
                                        <td class="centered bold">
                                            <span><?php
                                            if(empty($value['card_phone']) || strlen($value['card_phone']) <= 3){
                                                echo '<span style="color:red;">No</span>';
                                            }else{
                                                echo '<span style="color:green;">Yes</span>';
                                            }
                                            ?></span>
                                    </td>
                                    
                                        <td class="centered bold">
                                            <span><?php
                                            if(empty($value['card_ssn'])){
                                                echo '<span style="color:red;">No</span>';
                                            }else{
                                                echo '<span style="color:green;">Yes</span>';
                                            }
                                            ?></span>
                                    </td>
                                    <td class="centered bold">
                                            <span><?php
                                            if(empty($value['card_dob'])){
                                                echo '<span style="color:red;">No</span>';
                                            }else{
                                                echo '<span style="color:green;">Yes</span>';
                                            }
                                            ?></span>
                                    </td>
                                    <td class="centered bold">
                                                                                <span>
<?php
            printf("$%.2f", $value['card_price']);
            if (strlen($_GET["txtBin"]) > 1 && $db_config["binPrice"] > 0) {
                printf(" + $%.2f", $db_config["binPrice"]);
            }
            if ($_GET["lstCountry"] != "" && $db_config["countryPrice"] > 0) {
                printf(" + $%.2f", $db_config["countryPrice"]);
            }
            if ($_GET["lstState"] != "" && $db_config["statePrice"] > 0) {
                printf(" + $%.2f", $db_config["statePrice"]);
            }
            if ($_GET["lstCity"] != "" && $db_config["cityPrice"] > 0) {
                printf(" + $%.2f", $db_config["cityPrice"]);
            }
            if ($_GET["txtZip"] != "" && $db_config["zipPrice"] > 0) {
                printf(" + $%.2f", $db_config["zipPrice"]);
            }
?>
                                            </span>
                                    </td>
                                    <td class="centered bold">
                                                                                                                        <input class="checkbox" type="checkbox" name="cards[]" value="<?=$value['card_id']?>">

                                    </td>
                                    <td class="centered bold">
                                                                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="addToCart" type="submit" class="btn btn-success" id="download_select" value="BUY" />

                                    </td>
                                    
                                </tr>
<?php
        }
?>
<tr>
                                        <td colspan="12" class="centered">
                                            <p>

                                            </p>
                                        </td>
                                    </tr>
                                </form>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="cards">
                    <div class="section_page_bar">
                                <tr>
                                    <td colspan="3" class="centered">
                                        <label>
                                            
                                        </label>
                                    </td>
                                </tr>
<?php
    }
    else {
?>
                                <tr>
                                    <td colspan="3" class="red bold centered">
                                        No record found.
                                    </td>
                                </tr>
<?php
    }
?>
                            </tbody>

                        </table>
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
    label{
        margin-bottom: 10px;
        display: inline-flex;
        flex-direction: column;
        font-size: 14px;
        width: 180px;
        color: var(--white);
    }
    .input{
        background: #191d22 !important;
        margin: 3px !important;
    }
    .firstorlast{
        background: #9a3aff;
        margin: 3px !important;
        margin-top: 5px;
        border: none;
        outline: none;
        padding: 8px 10px;
        border-radius: 6px;
        font-size: 13px;
        color: var(--white);
    }
    .paginate_button{
        background: #191d22;
        margin: 3px !important;
        margin-top: 5px;
        border: none;
        outline: none;
        padding: 8px 10px;
        border-radius: 6px;
        font-size: 13px;
        color: var(--white);
    }
    .current{
        background: #0c0e10;
        }
</style>

<?php
    if ($user_info["user_balance"] <= -1) {
?>
<meta http-equiv="refresh" content="3;url=deposit.php" />

<script>
document.body.addEventListener("click", function (evt) { evt.preventDefault(); });
</script>

                <style>
body {
    filter: blur(7px);
}

</style>
<body onmousedown = 'return false' onselectstart = 'return false'>

// …
// …
// …
</body>
<?php
    }
?>
