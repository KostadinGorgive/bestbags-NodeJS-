<?php
require("./header.php");
if ($checkLogin) {
	if ($getinfoError == "" && $_POST["btnChangePwd"] != "") {
		if ($_POST["user_pass"] == "") {
			$changeInfoResult = "<span class=\"red bold centered\">Please enter your current password</span>";
		}
		else if (md5(md5($_POST["user_pass"]).$user_info["user_salt"]) == $user_info["user_pass"]) {
			switch (passwordFaild($_POST["user_pass_new"], $_POST["user_pass_new_re"])) {
				case 0:
					$user_update["user_salt"] = rand(100,999);
					$user_update["user_pass"] = md5(md5($_POST["user_pass_new"]).$user_update["user_salt"]);
					if($db->query_update(TABLE_USERS, $user_update, "user_id='".$_SESSION["user_id"]."'")) {
						$changeInfoResult = "<span class=\"green bold centered\">Change password successfully.</span>";
						$user_info["user_salt"] = $user_update["user_salt"];
						$user_info["user_pass"] = $user_update["user_pass"];
					}
					else {
						$changeInfoResult = "<span class=\"red bold centered\">Update user information error, please try again.</span>";
					}
					break;
				case 1:
					$changeInfoResult = "<span class=\"red bold centered\">New Password is too short.</span>";
					break;
				case 2:
					$changeInfoResult = "<span class=\"red bold centered\">New Password is too long.</span>";
					break;
				case 3:
					$changeInfoResult = "<span class=\"red bold centered\">New Password doesn't match.</span>";
					break;
			}
		}
		else {
			$changeInfoResult = "<span class=\"red bold centered\">Wrong password, please try again</span>";
		}
	}
	if ($getinfoError == "" && $_POST["btnChangeEmail"] != "") {
		if ($_POST["user_pass"] == "") {
			$changeInfoResult = "<span class=\"red bold centered\">Please enter your current password</span>";
		}
		else if (md5(md5($_POST["user_pass"]).$user_info["user_salt"]) == $user_info["user_pass"]) {
			switch (emailFaild($_POST["user_mail"])) {
				case 0:
					$user_update["user_mail"] = $_POST["user_mail"];
					if($db->query_update(TABLE_USERS, $user_update, "user_id='".$_SESSION["user_id"]."'")) {
						$changeInfoResult = "<span class=\"green bold centered\">Change email address successfully.</span>";
						$user_info["user_mail"] = $user_update["user_mail"];
					}
					else {
						$changeInfoResult = "<span class=\"red bold centered\">Update user information error, please try again.</span>";
					}
					break;
				case 1:
					$changeInfoResult = "<span class=\"red bold centered\">Invalid e-mail address.</span>";
					break;
			}
		}
		else {
			$changeInfoResult = "<span class=\"red bold centered\">Wrong password, please try again</span>";
		}
	}
	if ($getinfoError == "" && $_POST["btnChangeYahoo"] != "") {
		if ($_POST["user_pass"] == "") {
			$changeInfoResult = "<span class=\"red bold centered\">Please enter your current password</span>";
		}
		else if (md5(md5($_POST["user_pass"]).$user_info["user_salt"]) == $user_info["user_pass"]) {
			$user_update["user_yahoo"] = $_POST["user_yahoo"];
			if($db->query_update(TABLE_USERS, $user_update, "user_id='".$_SESSION["user_id"]."'")) {
				$changeInfoResult = "<span class=\"green bold centered\">Change Yahoo id successfully.</span>";
				$user_info["user_yahoo"] = $user_update["user_yahoo"];
			}
			else {
				$changeInfoResult = "<span class=\"red bold centered\">Update user information error, please try again.</span>";
			}
		}
		else {
			$changeInfoResult = "<span class=\"red bold centered\">Wrong password, please try again</span>";
		}
	}
	if ($getinfoError == "" && $_POST["btnChangeICQ"] != "") {
		if ($_POST["user_pass"] == "") {
			$changeInfoResult = "<span class=\"red bold centered\">Please enter your current password</span>";
		}
		else if (md5(md5($_POST["user_pass"]).$user_info["user_salt"]) == $user_info["user_pass"]) {
			$user_update["user_icq"] = $_POST["user_icq"];
			if($db->query_update(TABLE_USERS, $user_update, "user_id='".$_SESSION["user_id"]."'")) {
				$changeInfoResult = "<span class=\"green bold centered\">Change ICQ id successfully.</span>";
				$user_info["user_icq"] = $user_update["user_icq"];
			}
			else {
				$changeInfoResult = "<span class=\"red bold centered\">Update user information error, please try again.</span>";
			}
		}
		else {
			$changeInfoResult = "<span class=\"red bold centered\">Wrong password, please try again</span>";
		}
	}
?>

				<div class="page-title">ACCOUNT INFORMATION</div>
				<div class="new-box" style="align-items: center;" id="balance">
					<h3>E-MAIL ADDRESS</h3>
					<p><strong style="color:#eb3939;"><?=$user_info["user_mail"]?></strong></p>

					<h3>USERNAME</h3>
					<p><strong style="color:#eb3939;"><?=$user_info["user_name"]?></strong></p>

				</div>
<style>
	.new-box h3{
		margin-bottom:0px;
	}

	.new-box p{
		margin-bottom: 20px !important;
		margin-top: 5px !important;
	}
</style>
<?php
}
else {
	require("./minilogin.php");
}
require("./footer.php");
?>