<?php
   require("./header.php");
   if ($checkLogin) {
       
       
       
       
   ?>
<?php
   $sql = "SELECT DISTINCT card_country FROM `".TABLE_CARDS."` WHERE card_status = '".STATUS_DEFAULT."' AND card_userid = '".$_SESSION["user_id"]."'";
   $allCountry = $db->fetch_all_array($sql);
   if (count($allCountry) > 0) {
   	foreach ($allCountry as $country) {
   	}
   }
   ?>
<script type="text/javascript" src="bin-lookup.js"></script>
<div id="check_history">
   <div class="section_title">BIN CHECKER</div>
   <div class="section_page_bar">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <style>
         body {font-family: Arial, Helvetica, sans-serif;}
         /* The Modal (background) */
         .modal {
         display: none; /* Hidden by default */
         position: fixed; /* Stay in place */
         z-index: 1; /* Sit on top */
         padding-top: 250px; /* Location of the box */
         left: 0;
         top: 0;
         width: 100%; /* Full width */
         height: 100%; /* Full height */
         overflow: auto; /* Enable scroll if needed */
         background-color: rgb(0,0,0); /* Fallback color */
         background-color: rgba(0,0,0,0.6); /* Black w/ opacity */
         }
         /* Modal Content */
         .modal-content {
         background-color: #222831;
         margin: auto;
         padding: 20px;
         width: 30%;
         }
         /* The Close Button */
         .close {
         color: #f72b50;
         float: right;
         font-size: 28px;
         font-weight: bold;
         }
         .close:hover,
         .close:focus {
         color: #000;
         text-decoration: none;
         cursor: pointer;
         }
         .marg {
         width: 20%;
         padding: 5px 20px;
         margin: 8px 20px;
         box-sizing: border-box;
         border: 3px solid #ccc;
         -webkit-transition: 0.5s;
         transition: 0.5s;
         outline: none;
         }
         .marg {
         border: 3px solid #555;
         }
      </style>
      <style> 
         input[type=text] {
         position: center
         width: 100px;
         box-sizing: border-box;
         border: 2px solid #ccc;
         border-radius: 4px;
         font-size: 18px;
         background-color: white;
         background-image: url('searchicon.png');
         background-position: 10px 10px; 
         background-repeat: no-repeat;
         padding: 15px 25px 12px 20px;
         transition: width 0.4s ease-in-out;
         }
         .button {
         background-color: #9a3aff; /* Green */
         border: none;
         color: white;
         padding: 8px 32px;
         text-align: center;
         text-decoration: none;
         display: inline-block;
         font-size: 16px;
         margin: 4px 2px;
         cursor: pointer;
         -webkit-transition-duration: 0.4s; /* Safari */
         transition-duration: 0.4s;
         }
         .button1 {
         box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
         }
         .button2:hover {
         box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);
         }
      </style>
       <style>
       body {font-family: Arial, Helvetica, sans-serif;}
       /* The Modal (background) */
       .modal {
       display: none; /* Hidden by default */
       position: fixed; /* Stay in place */
       z-index: 1; /* Sit on top */
       padding-top: 155px; /* Location of the box */
       left: 0;
       top: 0;
       width: 100%; /* Full width */
       height: 100%; /* Full height */
       overflow: auto; /* Enable scroll if needed */
       background-color: rgb(0,0,0); /* Fallback color */
       background-color: rgba(0,0,0,0.6); /* Black w/ opacity */
       }
       /* Modal Content */
       .modal-content {
       background-color: #222831;
       margin: auto;
       padding: 20px;
       width: 30%;
       }
       /* The Close Button */
       .close {
       color: #f72b50;
       float: right;
       font-size: 28px;
       font-weight: bold;
       }
       .close:hover,
       .close:focus {
       color: #000;
       text-decoration: none;
       cursor: pointer;
       }
       .marg {
       width: 50%;
       padding: 10px 30px;
       margin: 40px 0;
       border-radius: 8px;
       -webkit-transition: 0.5s;
       transition: 0.5s;
       outline: none;
       }
       .marg {
       }
       select {
       width: 55%;
       padding: 16px 25px;
       border: none;
       border-radius: 4px;
       background-color: #ffffff;
       }
       textarea {
       width: 100%;
       height: 130px;
       padding: 12px 20px;
       box-sizing: border-box;
       border-radius: 8px;
       background-color: #ffffff;
       resize: none;
       }
       input[disabled='disabled']{    
        cursor: no-drop;
        background: #dddd;
       }
       </style>              
   </div>
   <div class="section_content">
      <div class="new-box" style="align-items: center;" id="balance">
         <center>
            <p style="color:white;">FREE SERVICE</p>
         </center>
         <form action="" method="get">
         <center style="display: flex">
             <input id="binText" type="text" value="<?php if(isset($_GET['bin']) && !empty($_GET['bin'])){ echo $_GET['bin'];}?>" name="bin" placeholder="Enter your BIN" id="ibin">
             <select name="saperated-by" class="saperate-val">
                 <option value=",">Saperated By (,)</option>
                 <!--<option value=",">Comma ( , )</option>-->
                 <!--<option value=";">Semicolon ( ; )</option>-->
                 <!--<option value="|">Vertical Bar ( | )</option>-->
                 <!--<option value="/">Slash ( / )</option>-->
             </select>
         </center>
         <br>
         <center><input type="submit" value="SEARCH" class="button button1" type="button" id="button-addon2" onclick="getbin()"></center>
             <span class="maximumenterdresponse" style="display:none; color: red; text-align: center">You've entered maximam</span>
         </form>
         </br>
         </br>
         </br>
         <table class="content_table">
            <thead>
               <tr>
                  <th>TYPE</th>
                  <th>BRAND</th>
                  <th>BANK</th>
                  <th>CREDIT/DEBIT</th>
                  <th>COUNTRY</th>
               </tr>
            </thead>
            <tbody>
                <?php 
                    if(isset($_GET['bin']) && !empty($_GET['bin'])){
                        // $mysqli -> query("SELECT * FROM Persons")
                        $bin = str_replace(' ', '', $_GET['bin']); ;
                        $saperatedBy = $_GET['saperated-by'];
                        
                        $spliyteData = explode($saperatedBy,$bin);
                        foreach($spliyteData as $serachsing){
                        
                        $selectData = "SELECT DISTINCT * FROM bins WHERE `card_bin`='$serachsing'";
                        $queryData = $conn->query($selectData);
                        while($row = mysqli_fetch_assoc($queryData)) {
                        
                ?>
                <tr>
                    <td class="centered">
                       <span id="type"><?php echo $row["card_level"]; ?></span>
                    </td>
                    <td class="centered">
                       <span id="brand"><?php echo $row["card_type"]; ?></span>
                    </td>
                    <td class="centered">
                       <span id="bank"><?php echo $row["card_bank"]; ?></span>
                    </td>
                    <td class="centered">
                       <span id="cd"><?php echo $row["card_type"]; ?></span>
                    </td>
                    <td class="centered">
                       <span id="country"><?php echo $row["card_country"]; ?></span>
                    </td>
                </tr>
                <?php }}}; ?>
            </tbody>
         </table>
            
      </div>
   </div>                  
   </td>
   </tr>
</div>
</div>
<script>
    $(document).ready(function(){
       
       
    $("#binText").keyup(function(){
          var saperateValue = $('.saperate-val').find(":selected").val();
          var binText = $("#binText").val(); 
       
   				var array = binText.split(saperateValue);
          
          var lastEl = array[array.length-1];

          var word = array.length;
          if(word > 20){
            $('#button-addon2').attr('disabled','disabled');
            $(".maximumenterdresponse").css('display','block');
          }else{
						if (lastEl.length > 5) {
							$("#binText").val(array+',');
						}
            $('#button-addon2').removeAttr('disabled');
            $(".maximumenterdresponse").css('display','none');
          }
        
    })
    $(".saperate-val").change(function(){
          var saperateValue = $('.saperate-val').find(":selected").val();
          var binText = $("#binText").val(); 
       
   				var array = binText.split(saperateValue);
          
          
          var lastEl = array[array.length-1];

				
				
          var word = array.length;
          if(word > 20){
            $('#button-addon2').attr('disabled','disabled');
            $(".maximumenterdresponse").css('display','block');
          }else{
          	if (lastEl.length > 5) {
							$("#binText").val(array+',');
						}
            $('#button-addon2').removeAttr('disabled');
            $(".maximumenterdresponse").css('display','none');
          }
        
    })
    
    
    })
    
    
</script>
<?php
   }
   else {
   	require("./minilogin.php");
   }
   require("./footer.php");
   ?>