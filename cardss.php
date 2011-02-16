<?php
require("./header.php");
if ($checkLogin) {
	if ($_GET["stagnant"] != "true") {
		$_GET["stagnant"] = "false";
	}
	$currentGet = "stagnant=".$_GET["stagnant"]."&"."txtBin=".$_GET["txtBin"]."&";
	if (isset($_GET["btnSearch"])) {
		$currentGet .= "lstCountry=".$_GET["lstCountry"]."&lstState=".$_GET["lstState"]."&lstCity=".$_GET["lstCity"]."&txtZip=".$_GET["txtZip"];
		$currentGet .= ($_GET["boxDob"]!="")?"&boxDob=".$_GET["boxDob"]:"";
		$currentGet .= ($_GET["boxSSN"]!="")?"&boxSSN=".$_GET["boxSSN"]:"";
		$currentGet .= "&btnSearch=Search&";
	}
	if ($_GET["stagnant"] == "true") {
		$searchExpire = "(card_year = ".date("Y")." AND card_month = ".date("n").")";
	} else {
		$searchExpire = "(card_year > ".date("Y")." OR (card_year = ".date("Y")." AND card_month > ".date("n")."))";
	}
	$searchBin = substr($db->escape($_GET["txtBin"]), 0, 6);
	$searchCountry = $db->escape($_GET["lstCountry"]);
	$searchState = $db->escape($_GET["lstState"]);
	$searchCity = $db->escape($_GET["lstCity"]);
	$searchZip = $db->escape($_GET["txtZip"]);
	$searchSSN = ($_GET["boxSSN"] == "on")?" AND card_ssn <> ''":"";
	$searchDob = ($_GET["boxDob"] == "on")?" AND card_dob <> ''":"";
	$sql = "SELECT count(*) FROM `".TABLE_CARDS."` WHERE ".$searchExpire." AND card_status = '".STATUS_DEFAULT."' AND card_userid = '0' AND card_bin LIKE '".$searchBin."%' AND ('".$searchCountry."'='' OR card_country = '".$searchCountry."') AND ('".$searchState."'='' OR card_state = '".$searchState."') AND ('".$searchCity."'='' OR card_city = '".$searchCity."') AND card_zip LIKE '".$searchZip."%'".$searchSSN.$searchDob;
	$totalRecords = $db->query_first($sql);
	$totalRecords = $totalRecords["count(*)"];
	$perPage = 20;
	$totalPage = ceil($totalRecords/$perPage);
	if (isset($_GET["page"])) {
		$page = $db->escape($_GET["page"]);
		if ($page < 1)
		{
			$page = 1;
		}
		else if ($page > $totalPage)
		{
			$page = 1;
		}
	}
	else {
		$page = 1;
	}
	$sql = "SELECT * FROM `".TABLE_CARDS."` WHERE ".$searchExpire." AND card_status = '".STATUS_DEFAULT."' AND card_userid = '0' AND card_bin LIKE '".$searchBin."%' AND ('".$searchCountry."'='' OR card_country = '".$searchCountry."') AND ('".$searchState."'='' OR card_state = '".$searchState."') AND ('".$searchCity."'='' OR card_city = '".$searchCity."') AND card_zip LIKE '".$searchZip."%'".$searchSSN.$searchDob." ORDER BY card_id DESC LIMIT ".(($page-1)*$perPage).",".$perPage;
	$listcards = $db->fetch_all_array($sql);
?>
				<div id="check_history">
					<div class="page-title">CARDS</div>
					<div class="section_page_bar">

					</div>
					<div class="section_content">
								<form id="searchForm" name="searchForm" method="GET" action="cards.php">
									<form name="addtocart" method="POST" action="./cart.php">

									<input type="hidden" name="stagnant" value="<?=$_GET["stagnant"]?>" />
									<label>
										BIN
										<input name="txtBin" placeholder="Enter Bin" type="text" class="input" id="txtBin" value="<?=$_GET["txtBin"]?>" size="12" maxlength="6">
									</label>


									<label>
									COUNTRY
									<select autofocus="autofocus" onfocus="this.select(All Countries)" name="lstCountry" class="input" id="lstCountry">
												<option value="">All Countries</option>
<?php
	$sql = "SELECT card_country, count(*) FROM `".TABLE_CARDS."` WHERE ".$searchExpire." AND card_status = '".STATUS_DEFAULT."' and card_userid = '0' GROUP BY card_country ORDER BY card_country";
	$allCountry = $db->fetch_all_array($sql);
	if (count($allCountry) > 0) {
		foreach ($allCountry as $country) {
			echo "<option value=\"".$country['card_country']."\"".(($_GET["lstCountry"] == $country['card_country'])?" selected":"").">".$country['card_country']."</option>";
		}
	}
?>
											</select>
									</label>


									<label>
										STATE
										<select autofocus="autofocus" onfocus="this.select(All States)" name="lstState" placeholde="Select State" class="input" id="lstState">
												<option value="">All States</option>
<?php
	$sql = "SELECT DISTINCT card_state FROM `".TABLE_CARDS."` WHERE ".$searchExpire." AND card_status = '".STATUS_DEFAULT."' and card_userid = '0' ORDER BY card_state";
	$allCountry = $db->fetch_all_array($sql);
	if (count($allCountry) > 0) {
		foreach ($allCountry as $country) {
			echo "<option value=\"".$country['card_state']."\"".(($_GET["lstState"] == $country['card_state'])?" selected":"").">".$country['card_state']."</option>";
		}
	}
?>
											</select>
									</label>

									<label>
											CITY
											<select name="lstCity" class="input" id="lstCity">
												<option value="">All Cities</option>
<?php
	$sql = "SELECT DISTINCT card_city FROM `".TABLE_CARDS."` WHERE ".$searchExpire." AND card_status = '".STATUS_DEFAULT."' and card_userid = '0' ORDER BY card_city";
	$allCountry = $db->fetch_all_array($sql);
	if (count($allCountry) > 0) {
		foreach ($allCountry as $country) {
			echo "<option value=\"".$country['card_city']."\"".(($_GET["lstCity"] == $country['card_city'])?" selected":"").">".$country['card_city']."</option>";
		}
	}
?>
											</select>
									</label>


									<label>
											ZIP
											<input name="txtZip" placeholder="Enter Zip" type="text" class="input" id="txtZip" value="<?=$_GET["txtZip"]?>" maxlength="8" size="12">
									</label>
									<label style="height: 55px;justify-content: flex-end;vertical-align: top;">
<input name="btnSearch" type="submit" class="btn btn-normal" id="btnSearch" value="SEARCH">
									</label>


										

										
									
								</form>
					</div>
				</div>
				<p></p>
								<p></p>
												<p></p>
																<p></p>
																				<p></p>
																								<p></p>
											<div style="color: var(--white);display: flex;justify-content: right;align-items: right;"><?php
	if ($totalRecords > 0) {
		echo "";
		if ($page>1) {
			echo "<a class=\"input\" href=\"?".$currentGet."page=".($page-1)."\">&lt;</a>";
			echo "<a class=\"input\" href=\"?".$currentGet."page=1\">1</a>";
		}
		if ($page>3) {
			echo "";
		}
		if (($page-1) > 1) {
			echo "<a class=\"input\" href=\"?".$currentGet."page=".($page-1)."\">".($page-1)."</a>";
		}
		echo "<input class=\"input\" type=\"TEXT\" class=\"page_go\" value=\"".$page."\" style=\"width: 30px;\" onchange=\"window.location.href='?".$currentGet."page='+this.value\"/>";
		if (($page+1) < $totalPage) {
			echo "<a class=\"input\" href=\"?".$currentGet."page=".($page+1)."\">".($page+1)."</a>";
		}
		if ($page < $totalPage-2) {
			echo "";
		}
		if ($page<$totalPage) {
			echo "<a class=\"input\" href=\"?".$currentGet."page=".($page+1)."\">&gt;</a>";
		}
	}
?></div>
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
								    <th>SELLER</th>
									<th>CARD NUMBER</th>
									<th>NAME</th>
									<th>COUNTRY</th>
									<th>STATE</th>
									<th>CITY</th>
									<th>ZIP</th>
									<th>PRICE</th>
									<th><input class="checkbox_select" type="checkbox" name="selectAllCards" id="selectAllCards" onclick="checkAll(this.id, 'cards[]')" value=""></th>
									<th>ADD TO CART</th>
								</tr>
							</thead>
							<tbody>
								<?php
	if (count($listcards) > 0) {
		foreach ($listcards as $key=>$value) {
			$card_firstname = explode(" ", $value['card_name']);
			$card_firstname = $card_firstname[0];
?>

								<tr class="formstyle">
								    
								    <td class="centered">
									
										<span><?php
										
										if($value['seller'] == 'MajorShop'){
										    echo '<span style="color:#43a33b">'.$value['seller'].'</span>';
										}else{
										    echo getUserData($value['seller'], "user_name", $conn);
										}
										
										?></span>
									</td>
								
									<td class="centered">
									
										<span><?=$value['card_bin']?>**********</span>
									</td>
									<td class="centered bold">
										 <span><?=$card_firstname?></span>
									</td>
									<td class="centered bold">
                                                                <span><?=$value['card_country']?></span>
									</td>
									<td class="centered bold">
                                                                                 <span><?=$value['card_state']?></span>			
					                                   	</td>
									<td class="centered bold">
                                                                                 <span><?=$value['card_city']?></span>
									</td>
									<td class="centered bold">
                                                                                   <span><?=$value['card_zip']?></span>
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
												<label>
													<input name="txtBin" type="hidden" id="txtBin" value="<?=$_GET["txtBin"]?>" />
													<input name="txtCountry" type="hidden" id="txtCountry" value="<?=$_GET["lstCountry"]?>" />
													<input name="lstState" type="hidden" id="lstState" value="<?=$_GET["lstState"]?>" />
													<input name="lstCity" type="hidden" id="lstCity" value="<?=$_GET["lstCity"]?>" />
													<input name="txtZip" type="hidden" id="txtZip" value="<?=$_GET["txtZip"]?>" />
												</label>
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