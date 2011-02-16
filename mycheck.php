<?php
require("./header.php");
if ($checkLogin) {
	if ($_POST["clear_history"] != "") {
		$check_update["check_hide"] = "1";
		if ($db->query_update(TABLE_CHECKS, $check_update, "check_userid='".$_SESSION["user_id"]."'")) {
			$clearHistoryResult = "<span class=\"green red centered\">Clear check history successfully</span>";
		}
		else {
			$clearHistoryResult = "<span class=\"bold red centered\">Clear check history error</span>";
		}
	}
	$sql = "SELECT `".TABLE_CHECKS."`.*, `".TABLE_CARDS."`.card_id, AES_DECRYPT(`".TABLE_CARDS."`.card_number, '".strval(DB_ENCRYPT_PASS)."') AS card_number FROM `".TABLE_CHECKS."` JOIN `".TABLE_CARDS."` ON ".TABLE_CHECKS.".check_userid = ".$_SESSION["user_id"]." AND ".TABLE_CHECKS.".check_cardid = ".TABLE_CARDS.".card_id AND ".TABLE_CHECKS.".check_hide = '0' ORDER BY check_id DESC LIMIT 0, 50";
	$listcards = $db->fetch_all_array($sql);
?>
				<div id="check_history">
				<div class="section_title">CHECK HISTORY</div>
					<div class="section_title"><?=$clearHistoryResult?></div>
					<div class="section_content">
						<table class="content_table_check">
							<thead>
								<tr>
									<th>DATE</th>
									<th>Card Number</th>
									<th>Check Result</th>
								</tr>
							</thead>
							<tbody>
<?php
	if (count($listcards) > 0) {
		foreach ($listcards as $key=>$value) {
?>
								<tr class="formstyle">
									<td class="centered">
										<span><?=date("H:i:s d/M/Y", $value['check_time'])?></span>
									</td>
									<td class="centered bold">
										<span><?=$value['card_number']?></span>
									</td>
									<td class="centered bold">
<?php
			switch ($value['check_result']) {
				case strval(CHECK_VALID):
					echo "<span class=\"tag-success\">VALID</span>";
					break;
				case strval(CHECK_INVALID):
					echo "<span class=\"tag-del\">TIMEOUT</span>";
					break;
				case strval(CHECK_REFUND):
					echo "<span class=\"tag-del\">REFUNDED</span>";
					break;
				case strval(CHECK_UNKNOWN):
					echo "<span class=\"tag-del\">UNKNOWN</span>";
					break;
				default :
					echo "<span class=\"black bold\">UNCHECK</span>";
					break;
			}
?>
									</td>
								</tr>
<?php
		}
?>
								<tr>
									<td colspan="3" class="centered">
										<label>
											<form action="" method="POST">
												<input name="clear_history" type="submit" class="btn btn-normal" id="clear_history" value="Clear Check History" >
											</form>
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