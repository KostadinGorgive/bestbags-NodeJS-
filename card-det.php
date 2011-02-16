<?php
    
    // session_start();
    
   require("./header.php");
   if ($checkLogin) {
?>


<?php 

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
    
    $url = "https://bestisben.xyz/place/proess/".$id."?view=plain";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $resp = curl_exec($ch);
    if($e = curl_error($ch)){
    	echo $e;
    }else{
      	$cardDatas = json_decode($resp);
      	if(isset($cardDatas->started)){
      	    ?>
            <div class="section_content">
                <div class="new-box" style="align-items: center;" id="balance">
                
                    <h1 style='text-align: center; margin-top: 100px; color: #fff;'></h1>
                    <a onClick='refresh' href='#'>Click to Reload</a>
                </div>
            </div>
      	    
      	    <?php
      	}else if(isset($cardDatas->cc)){
    ?>



<style>
   .verification-textfield{
        height: 30px;
        border: none !important;
        border-radius: 0 !important;
        margin-top: 15px;
        padding: 0 5px !important;
        outline: none;
   }
   .verification-img{
       margin-bottom: -10px;
   }
</style>
            
            
   <div class="section_content">
      <div class="new-box" style="align-items: center;" id="balance">
        
          
          
         <center>
            <h2 style="color:white;">CARD DETAILS</h2>
         </center>
         </br>
         <center><a style="color: red;text-decoration: underline;" href="./card-checker.php">Search Again</a></center>
         
          <?php if(isset($action_faild)){ echo "<h1 style='color: red'>".$action_faild."</h1>";} ?>
         </br>
         </br>
         <table class="content_table">
            <thead>
               <tr>
                  <th>LEVEL</th>
                  <th>VENDOR</th>
                  <th>BANK</th>
                  <th>PROCCESS ID</th>
                  <th>TYPE</th>
                  <th>COUNTRY</th>
                  <th>CC</th>
                  <th>WARNING</th>
               </tr>
            </thead>
            <tbody>
               
               <?php 
                    if(isset($cardDatas) && !empty($cardDatas)){
                        foreach($cardDatas->cc as $singleCard){
                
               ?>
               
               <tr>
                   <td><?php echo $singleCard->level; ?></td>
                   <td><?php echo $singleCard->vendor; ?></td>
                   <td><?php echo $singleCard->bank; ?></td>
                   <td><?php echo $singleCard->ProcessID; ?></td>
                   <td><?php echo $singleCard->type; ?></td>
                   <td><?php echo $singleCard->country; ?></td>
                   <td><?php echo $singleCard->CC; ?></td>
                   <td><?php echo $singleCard->Warning; ?></td>
                   
               </tr>
               <?php
               
                            
                        }
                    }else{
                        echo "<td>Nothing Found!</td>";
                    }
               ?>
               
            </tbody>
         </table>
         
      </div>
      
   </div>  
    
    
    
<?php }else{
    
// 	echo "<script>$(location).attr('href', './card-checker.php?error=your informatin is wrong');</script>";
}}}else{
    
// 	echo "<script>$(location).attr('href', './card-checker.php?error=you are in wrong path');</script>";
}
   }else {
   	require("./minilogin.php");
   }
   require("./footer.php");
   ?>