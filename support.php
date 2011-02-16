<?php
require("./header.php");
if ($checkLogin) {
	$sql = "SELECT user_mail FROM `".TABLE_USERS."` WHERE user_id='".$_SESSION['user_id']."'";
	$user_mail = $db->query_first($sql);
	if ($user_mail) {
		$user_mail = $user_mail["user_mail"];
	}
	if ($_POST["btnSend"] != "") {
		$to = $db_config["support_email"];
		$subject = "Support [".$_SESSION["user_name"]."]: ".$_POST["message"];
		$message = "From user".$_SESSION["user_name"].",\r\n".$_POST["message"];
		$headers = "From: ".$_POST["email"]."\r\n" .
			"Reply-To: ".$_POST["email"]."\r\n" .
			"X-Mailer: PHP/".phpversion();
		if (@mail($to, $subject, $message, $headers)) {
			$sendResult = "<span class=\"green bold centered\">Your new password has been sent to your email address.</span>";
		}
		else {
			$sendResult = "<span class=\"red bold centered\">Can't send email address, please contact administator for support.</span>";
		}
	}
?>					<div class="page-title">SUPPORT</div>
				<div class="new-box" style="align-items: center;" id="balance">
					<h3>Jabber</h3>
					<p><strong style="color:#eb3939;">majorshop@jabbim.ru</strong></p>
                    <p></p>
					<h3>Email</h3>
					<p><strong style="color:#eb3939;">support@majorcc.shop</strong></p>
                    <p></p>
					<h3>Telegram</h3>

					<p><strong style="color:#eb3939;">@majorshop77</strong></p>
                     <p></p>
                     <p></p>
	                <h4>CAUTION : ANY OTHER CONTACTS DO NOT BELONG TO US</h4>
				</div>
					
					<div class="section_content">
						<table class="">
							<tbody>
<?php
	if ($db_config["support_yahoo1"] != "") {
?>
								
<?php
	}
	if ($db_config["support_yahoo2"] != "") {
?>
<?php
	}
	if ($db_config["support_icq"] != "") {
?>
								<tr>
									<td class="support_title">
										<span class="black bold">ICQ support:</span>
									</td>
									<td class="support_content">
										<a href="http://www.icq.com/people/cmd.php?uin=<?=$db_config["support_icq"]?>&action=message"><?=$db_config["support_icq"]?></a>
									</td>
								</tr>
<?php
	}
	if ($db_config["support_skype"] != "") {
?>
								<tr>
									<td class="support_title">
										<span class="black bold">Skype support:</span>
									</td>
									<td class="support_content">
										<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>
										<a href="skype:<?=$db_config["support_skype"]?>?call"><img src="http://download.skype.com/share/skypebuttons/buttons/call_blue_white_124x52.png" style="border: none;" width="124" height="52" alt="Skype Me�!" /></a>
									</td>
								</tr>
<?php
	}
?>
							</tbody>
						</table>
					</div>
				</div>
				<div id="balance">
					<div class="section_title"><?=$sendResult?></div>
					<div class="section_content">
					</div>
				</div>
<?php
}
else {
	require("./minilogin.php");
}
require("./footer.php");
?>