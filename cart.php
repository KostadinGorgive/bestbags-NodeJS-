<?php
require("./header.php");
if ($checkLogin) {
	if (isset($_POST["btnDeleteSelect"])) {
		$allCards = $_POST["cards"];
		$countDeleted = 0;
		if (count($allCards) > 0) {
			foreach ($allCards as $key=>$value) {
				$countDeleted++;
				$_SESSION["shopping_total"] -= $_SESSION["shopping_card"][$value]["card_price"] + $_SESSION["shopping_card"][$value]["binPrice"] + $_SESSION["shopping_card"][$value]["countryPrice"] + $_SESSION["shopping_card"][$value]["statePrice"] + $_SESSION["shopping_card"][$value]["cityPrice"] + $_SESSION["shopping_card"][$value]["zipPrice"];
				unset($_SESSION["shopping_card"][$value]);
			}
		}
		if ($countDeleted > 0) {
			$add_msg = "<span class=\"green bold\">Successfuly deleted ".$countDeleted." item(s) from shopping cart.</span>";
		}
		else {
			$add_msg = "<span class=\"red bold\">Please select one or more card(s) from your shopping cart to delete.</span>";
		}
?>
				<script type="text/javascript">setTimeout("window.location = './cart.php'", 1000);</script>
				<div id="cart">
					<div class="section_title">YOUR CART</div>
					<div class="section_content centered">
						<?=$add_msg?><br/>
						<a href="./cart.php">Click here if your browser does not automatically redirect you.</a>
					</div>
				</div>
<?php
	}
	else if (isset($_POST["addToCart"]) && is_array($_POST["cards"])) {
		$allCards = $_POST["cards"];
		$lastCards = $db->escape($allCards[count($allCards)-1]);
		unset($allCards[count($allCards)-1]);
		$sql = "SELECT card_id, AES_DECRYPT(card_number, '".strval(DB_ENCRYPT_PASS)."') AS card_number, card_bin, card_cvv, card_name, card_country, card_state, card_city, card_zip, card_ssn, card_dob, card_price FROM `".TABLE_CARDS."` WHERE card_status = '".STATUS_DEFAULT."' AND card_userid = 0 AND card_id IN (";
		if (count($allCards) > 0) {
			foreach ($allCards as $key=>$value) {
				$sql .= "'".$db->escape($value)."', ";
			}
		}
		$sql .= "'".$lastCards."')";
		$addCards = $db->fetch_all_array($sql);
		if (count($addCards) > 0) {
			if (!isset($_SESSION["shopping_card"]) || !isset($_SESSION["shopping_total"])) {
				$_SESSION["shopping_card"] = array();
				$_SESSION["shopping_total"] = 0;
			}
			$countAdded = 0;
			foreach ($addCards as $key=>$value) {
				if (in_array($value["card_id"], array_keys($_SESSION["shopping_card"]))) {
					$_SESSION["shopping_total"] -= $_SESSION["shopping_card"][$value["card_id"]]["card_price"] + $_SESSION["shopping_card"][$value["card_id"]]["binPrice"] + $_SESSION["shopping_card"][$value["card_id"]]["countryPrice"] + $_SESSION["shopping_card"][$value["card_id"]]["statePrice"] + $_SESSION["shopping_card"][$value["card_id"]]["cityPrice"] + $_SESSION["shopping_card"][$value["card_id"]]["zipPrice"];
					unset($_SESSION["shopping_card"][$value["card_id"]]);
				}
				$countAdded++;
				$value["card_bin"] = $value["card_bin"];
				$value["card_number"] = $value["card_number"];
				if (strlen($_POST["txtBin"]) > 1) {
					$value["binPrice"] = $db_config["binPrice"];
				}
				else {
					$value["binPrice"] = 0;
				}
				if ($_POST["txtCountry"] != "") {
					$value["countryPrice"] = $db_config["countryPrice"];
				}
				else {
					$value["countryPrice"] = 0;
				}
				if ($_POST["lstState"] != "") {
					$value["statePrice"] = $db_config["statePrice"];
				}
				else {
					$value["statePrice"] = 0;
				}
				if ($_POST["lstCity"] != "") {
					$value["cityPrice"] = $db_config["cityPrice"];
				}
				else {
					$value["cityPrice"] = 0;
				}
				if ($_POST["txtZip"] != "") {
					$value["zipPrice"] = $db_config["zipPrice"];
				}
				else {
					$value["zipPrice"] = 0;
				}
				$_SESSION["shopping_card"][$value["card_id"]] = $value;
				$_SESSION["shopping_total"] += $value["card_price"] + $value["binPrice"] + $value["countryPrice"] + $value["statePrice"] + $value["cityPrice"] + $value["zipPrice"];
			}
		}
		if ($countAdded > 0) {
			$add_msg = "<span class=\"green bold\">Successfuly added ".$countAdded." item(s) to shopping cart.</span>";
		}
		else {
			$add_msg = "<span class=\"red bold\">Please select one or more card(s) to add to your shopping cart.</span>";
		}
?>
				<script type="text/javascript">setTimeout("window.location = './cart.php'", 1000);</script>
				<div id="cart">
					<div class="section_title">YOUR CART</div>
					<div class="section_content centered">
						<?=$add_msg?><br/>
						<a href="./cart.php">Click here if your browser does not automatically redirect you.</a>
					</div>
				</div>
<?php
	}
	else {
		if ($_POST["btnBuy"] != "" && count($_SESSION["shopping_card"]) > 0) {
			$user_balance = $user_info["user_balance"];
			if (doubleval($user_balance) >= doubleval($_SESSION["shopping_total"])) {
			    
			    
				$cards_ids = array_keys($_SESSION["shopping_card"]);
				$cards_update["card_userid"] = $_SESSION["user_id"];
				$cards_update["card_buyTime"] = time();
				$cards_update_where = "card_id IN (";
				if (is_array($cards_ids)) {
					$lastCard = $db->escape($cards_ids[count($cards_ids) - 1]);
					unset($cards_ids[count($cards_ids) - 1]);
					if (count($cards_ids) > 0) {
						foreach ($cards_ids as $k => $v) {
						    
				            $temp_card = mysqli_query($conn, "SELECT * FROM `cards` WHERE `card_id`='$v';");
                            $row = mysqli_fetch_array($temp_card);
                            $seller = $row['seller'];
                            $price = round(floatval(($row['card_price'] * 75) / 100),2);
						    
						    $result = mysqli_query($conn, "UPDATE `users` SET seller_balance = seller_balance + '$price' WHERE `user_id`='$seller';");
						    
						    
						    
							$cards_update_where .= "'".$db->escape($v)."', ";
						}
					}
					
				}
					$temp_card = mysqli_query($conn, "SELECT * FROM `cards` WHERE `card_id`='$lastCard';");
                    $row = mysqli_fetch_array($temp_card);
                    $seller = $row['seller'];
                    $price = round(floatval(($row['card_price'] * 75) / 100),2);
				    
				    $result = mysqli_query($conn, "UPDATE `users` SET seller_balance = seller_balance + '$price' WHERE `user_id`='$seller';");
						    
					$cards_update_where .= "'$lastCard'";
				$cards_update_where .= ")";
				$carts_add["cart_userid"] = $_SESSION["user_id"];
				$carts_add["cart_item"] = serialize($_SESSION["shopping_card"]);
				$carts_add["cart_total"] = doubleval($_SESSION["shopping_total"]);
				$carts_add["cart_before"] = doubleval($user_balance);
				$carts_add["cart_time"] = time();
				$credit_update["user_balance"] = doubleval($user_balance)-doubleval($_SESSION["shopping_total"]);
				if ($db->query_insert(TABLE_CARTS, $carts_add)) {
					if ($db->query_update(TABLE_CARDS, $cards_update, $cards_update_where)) {
						if ($db->query_update(TABLE_USERS, $credit_update, "user_id='".$_SESSION["user_id"]."'")) {
							$user_info["user_balance"] = $credit_update["user_balance"];
							$_SESSION["shopping_card"] = array();
							$_SESSION["shopping_total"] = 0;
							$buyResult = "<script type=\"text/javascript\">setTimeout(\"window.location = 'mycards.php'\", 1000);</script><span class=\"green bold centered\">Your order is completed, go to 'My Cards' to view your cards.</span>";
						} else {
							$buyResult = "<span class=\"red bold centered\">Update Credit: SQL Error, please try again.</span>";
						}
					} else {
							$buyResult = "<span class=\"red bold centered\">Update Cards: SQL Error, please try again.</span>";
					}
				}
				else {
					$buyResult = "<span class=\"red bold centered\">Insert Order Record: SQL Error, please try again.</span>";
				}
			}
			else {
				$buyResult = "<span class=\"red bold centered\">You don't have enough balance, please fund more balance to buy.</span>";
			}
		}
?>
				<div id="cart">
					<div class="section_title">YOUR CART</div>
					<div class="section_title"><?=$buyResult?></div>
					<div class="section_content">
						<table class="content_table">
						<form name="shoping_cart" method="POST" action="">
							<thead>
								
								<tr>
									<th>CARD NUMBER</span></th>
									<th>NAME</span></th>
									<th>COUNTRY</span></th>
									<th>STATE</span></th>
									<th>CITY</span></th>
									<th>ZIP</span></th>
									<th>PRICE</span></th>
									<th>
										<input class="formstyle_cart" type="checkbox" name="selectAllCards" id="selectAllCards" onclick="checkAll(this.id, 'cards[]')" value=""></th>
								</tr>
							</thead>
							<tbody>
<?php
		if (count($_SESSION["shopping_card"]) > 0) {
			foreach ($_SESSION["shopping_card"] as $key=>$value) {
				$card_firstname = explode(" ", $value['card_name']);
				$card_firstname = $card_firstname[0];
?>
									<tr class="formstyle_cart">
										<td class="centered bold">
											<span><?=$value['card_bin']?>*********</span>
										</td>
										<td class="centered">
											<span><?=$card_firstname?></span>
										</td>
										<td class="centered">
											<span><?=$value['card_country']?></span>
										</td>
										<td class="centered">
											<span><?=$value['card_state']?></span>
										</td>
										<td class="centered">
											<span><?=$value['card_city']?></span>
										</td>
										<td class="centered">
											<span><?=$value['card_zip']?></span>
										</td>
										<td class="centered bold">
											<span>
<?php
				printf("$%.2f", $value['card_price']);
				if ($value["binPrice"] > 0) {
					printf(" + $%.2f", $value["binPrice"]);
				}
				if ($value["countryPrice"] > 0) {
					printf(" + $%.2f", $value["countryPrice"]);
				}
				if ($value["statePrice"] > 0) {
					printf(" + $%.2f", $value["statePrice"]);
				}
				if ($value["cityPrice"] > 0) {
					printf(" + $%.2f", $value["cityPrice"]);
				}
				if ($value["zipPrice"] > 0) {
					printf(" + $%.2f", $value["zipPrice"]);
				}
?>
											</span>
										</td>
										<td class="centered">
											<input class="formstyle_cart" type="checkbox" name="cards[]" value="<?=$value['card_id']?>">
										</td>
									</tr>
<?php
			}
		}
		else {
?>
									<tr>
										<td colspan="8" class="centered">
											<span class="red bold">Your shopping cart is empty.</span>
										</td>
									</tr>
<?php
		}
?>
									<tr>
										<td colspan="5" class="red bold right">
											Total:
										</td>
										<td class="centered">
											<span class="red bold">$<?=number_format($_SESSION["shopping_total"], 2, '.', '')?></span>
										</td>
										<td class="centered">
													<input name="btnBuy" type="submit" class="btn btn-normal" id="btnBuy" value="Purchase" />
										</td>
										<td class="centered">
													<input name="btnDeleteSelect" type="submit" class="btn btn-del" id="btnDeleteSelect" value="Delete" />
										</td>
									</tr>
									<tr>
										<td colspan="8" class="centered">
											<p>
												<label>
												</label>
											</p>
										</td>
									</tr>
								</form>
							</tbody>
						</table>
					</div>
				</div>
<?php
	}
}
else {
	require("./minilogin.php");
}
require("./footer.php");
?>