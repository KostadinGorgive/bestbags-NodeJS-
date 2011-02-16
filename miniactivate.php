<?php
	if ($_POST["btnUpgradeVip"] != "") {
		if ($db != NULL) {
			$user_balance = $user_info["user_balance"];
			if (doubleval($user_balance) >= doubleval($db_config["activate_fee"])) {
				$user_update["user_balance"] = doubleval($user_balance)-doubleval($db_config["activate_fee"])+doubleval($db_config["activate_balance"]);
				$user_update["user_groupid"] = PER_USER;
				if ($db->update(TABLE_USERS, $user_update, "user_id='".$_SESSION["user_id"]."'")) {
					$user_info["user_balance"] = $user_update["user_balance"];
					$upgradeVipResult = "<script type=\"text/javascript\">setTimeout(\"window.location = './firsttime.php'\", 0);</script><span class=\"success\">Activate account successful, click here if browser not redirect.</span>";
				} else {
					$upgradeVipResult = "<span class=\"error\">Update Credit: SQL Error, please try again.</span>";
				}
			}
			else {
				$upgradeVipResult = "<span class=\"error\">You don't have enough balance, please deposit more balance to activate your account.</span>";
			}
		} else {
			header("Location: ./activate.php");
		}
	}
	if(strlen($user_info["user_active"])>1)
	{
			function rand_string($x)
			{
				$Strings = "abcdefghiklmnopqrstuvwxyz0123456789";
				$Str = "";
				while(strlen($Str) < $x)
				{
					$Rand = Rand(0,strlen($Strings));
					$Str .= substr($Strings,$Rand,1);
				}
				return $Str;
			}
			if(isset($_REQUEST["code"])){
					if($_POST["code"] == $user_info["user_active"]){
						$user_update["user_active"] = "";
						if ($db->update(TABLE_USERS, $user_update, "user_id='".$_SESSION["user_id"]."'")) {
							echo "<script type=\"text/javascript\">setTimeout(\"window.location = './activate.php'\", 1000);</script><span class=\"success\">Verify mail successful, click here if browser not redirect.</span>";
						} else {
							$upgradeVipResult = "<span class=\"error\">Update Credit: SQL Error, please try again.</span>";
						}
					}
					else echo "Wrong verify code!<br>";
			}
			else{
				if($_POST["submit"]=="Resend code"){
						$user_update["user_active"] = rand_string(16);
						$user_update["user_mail"] = $db->escape($_POST["mail"]);
						if ($db->update(TABLE_USERS, $user_update, "user_id='".$_SESSION["user_id"]."'")) {
							echo "<script type=\"text/javascript\">setTimeout(\"window.location = './activate.php'\", 1000);</script><span class=\"success\">Verify mail successful, click here if browser not redirect.</span>";
						} else {
							$upgradeVipResult = "<span class=\"error\">Update Credit: SQL Error, please try again.</span>";
						}
						$subject = "Reactive - ".$db_config["name_service"];
						$message = "Hi ".$db->escape($_POST["user_name"])."\n Welcome to ".$db_config["name_service"]." Service, you can buy paypal and Card Credit From our service.\n
						- Your Active Code is: ".$user_add["user_active"]."\n
						- ".$db_config["site_url"]."/activate.php?code=".$user_add["user_active"]." View this link to active your account!";
						send_mail($_POST["user_mail"], $db_config["support_email"], $db_config["support_email"], $db_config["name_service"], $subject, $message);	
				}
			}
				?>
				<br>Active Mail
				<form method="POST" >
				Verify Code: <input name="code" type="text">
				<input type="submit" name="submit" value="Active">
				</form>
				<br>
				Resend Active Code
				<form method="POST" >
				Mail: <input name="mail" type="text">
				<input type="submit" name="submit" value="Resend code">
				</form>
				<br>
				<?
	}
	else{
?>
				<br>
				<div id="upgrade_vip">
					<div class="section_title">1. TO BECOME ACTIVE MEMBER YOU MUST ACTIVATE YOUR ACCOUNT</div>
					<FORM>
					  <div align="center">
				    <INPUT TYPE="BUTTON" VALUE="FIRST ADD $<?=$db_config["activate_fee"]?> THAN CLICK ACTIVATE BELOW" ONCLICK="window.location.href='activate-fund.php'">
					  </div>
					</FORM>
					<div class="section_title"><?=$upgradeVipResult?></div>
					<div class="section_content">
						<table class="content_table">
							<tbody>
						  <form name="upgrade_vip" method="POST" action="">
									<tr>
										<td class="centered large">
											To become an active member on our system, you have to pay <span class="bold red">$<?=$db_config["activate_fee"]?></span> to activate your account. Once Activated, You will get <span class="bold red">$<?=$db_config["activate_balance"]?></span> on your account.
										</td>
									</tr>
									<tr>
										<td colspan="5" class="centered">
											<p>
												<label>
													<input name="btnUpgradeVip" type="submit" class="bold" id="btnUpgradeVip" value="Activate" />
												</label>
												<label>
													<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onclick="window.location='./index.php'"/>
												</label>
											</p>
										</td>
									</tr>
						  </form>
							</tbody>
						</table>
					</div>
				</div>
		<?}?>