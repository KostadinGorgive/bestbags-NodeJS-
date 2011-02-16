<?php
    
   require("./header.php");
   if ($checkLogin) {


       
       
?>


<?php 

require_once dirname(__FILE__) . '/vendor/autoload.php';

if (isset($_POST['canyouseeme'])) {

$canyouseeme = $_POST['canyouseeme'];
$verification = $_POST['verificationtext'];
$text = $_POST['text'];

$url = "https://bestisben.xyz/place/vipchecker1";

$data = array(
    'password' => 'Tweeters05',
    'verification' => $verification,
    'canyouseeme' => $canyouseeme,
    'text' => $text
);
$response = Requests::post($url, array(), $data);

if($response->url == $url){
    
$action_faild =  "The cards that were placed have been checked before and that they must place new cards or wait 24 hours to check the same cards again";

}else{



$url = $response->url."?view=plain";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$resp = curl_exec($ch);
if($e = curl_error($ch)){
    echo $e;
}else{
    
    $jsonDecode = json_decode($resp);
    
    $idSingSplt = explode("/",$response->url);
    $idSing = $idSingSplt[5];

    $time = time()+20;
    $time2 = 0;
    while(isset($jsonDecode->started) && $time > $time2){
        
        $time2 = time();
    }
    echo "<script>$(location).attr('href', './card-det.php?id=".$idSing."');</script>";
    
    } }
    
    if(!isset($user_id)){
        $user_id = $user_info["user_id"]; 
    }
    
    
    }else{} ?>



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
            <h4 class="card-title">CARDS CHECKER</h4>
         </center>
         <form action="" method="POST">
            <textarea name="text" class="form-control" placeholder="1234123412341234|04|2022|1234
CCnum:: 4321432143214321Cvv: 123Expm: 06Expy: 23
Supported ANY CC format, even message" cols="200" rows="10"><?php if(isset($_POST['text']) && !empty($_POST['text'])){ echo $_GET['text'];}?></textarea>
            <br>
            <?php
            $url = "https://bestisben.xyz/place/api/request/image";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $resp = curl_exec($ch);
            if($e = curl_error($ch)){
                echo $e;
            }else{
                $decodeVerification = json_decode($resp);   
                $VerificationImgDecrypy = $decodeVerification->encode;
                $VerificationId = $decodeVerification->id;
            }
            
            ?>
            <img class="verification-img" src="data:image/gif;base64,<?php echo $VerificationImgDecrypy; ?>">
            <input placeholder="CAPTCHA" name="verificationtext" class="verification-textfield" type="text">
            <input name="canyouseeme" value="<?php echo $VerificationId; ?>" type="hidden">
         <br>
         <center><input style="margin-top: 10px" type="submit" value="CHECK" class="btn btn-normal" type="button" id="button-addon2" onclick="getbin()"></center>
                           

         </form>
         </br>
         
          <?php if(isset($action_faild)){ echo "<h1 style='color: red'>".$action_faild."</h1>";} ?>
         </br>
         </br>
         
         
      </div>
      
   </div>  
    
        <style>
    .verification-img{
    -webkit-filter: invert(70%); /* Safari/Chrome */
    filter: invert(70%);
}
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

    </style>

<?php 
   }else {
    require("./minilogin.php");
   }
   require("./footer.php");
   ?>