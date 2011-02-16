<?php
require("./header_pages.php");
if ($checkLogin) {
	$sql = "SELECT * FROM `".TABLE_ORDERS."` WHERE order_userid='".$_SESSION['user_id']."' ORDER BY order_id DESC LIMIT 0, 10";
	$order_historys = $db->fetch_all_array($sql);
?>
				<div id="purchase_history">
					<div class="section_title">PURCHASED HISTORY (last 10 orders)</div>
					<div class="section_content">
						<table id="content_table">
							<tbody>
								<tr>
									<td class="formstyle_deposit">
										<strong>ORDER ID</strong>
									</td>
									<td class="formstyle_deposit">
										<strong>DATE</strong>
									</td>
									<td class="formstyle_deposit">
										<strong>METHOD</strong>
									</td>
									<td class="formstyle_deposit">
										<strong>AMOUNT</strong>
									</td>
									<td class="formstyle_deposit">
										<strong>BEFORE BALANCE</strong>
									</td>
									<td class="formstyle_deposit">
										<strong>AFTER BALANCE</strong>
									</td>
									<td class="formstyle_deposit">
										<strong>ORDER PROOF</strong>
									</td>
								</tr>
<?php
	if (count($order_historys) > 0) {
		foreach ($order_historys as $key=>$value) {
?>
								<tr class="formstyle_deposit">
									<td class="">
										<span><?=$value['order_id']?></span>
									</td>
									<td class="">
										<span><?=date("H:i:s d/M/Y", $value['order_time'])?></span>
									</td>
									<td class="">
										<span><?=$value['order_paygate']?></span>
									</td>
									<td class="bold ">
										<span>$<?=$value['order_amount']?></span>
									</td>
									<td class="">
										<span>$<?=$value['order_before']?></span>
									</td>
									<td class="">
										<span>$<?=$value['order_before'] + $value['order_amount']?></span>
									</td>
									<td class="">
										<span><?=$value['order_proof']?></span>
									</td>
								</tr>
<?php
		}
	}
	else {
?>
								<tr>
									<td colspan="7" class="red bold ">
										You don't have any order yet.
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