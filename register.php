<?php
require("./header.php");
if (!$checkLogin) {
	$showForm = true;
	if ($_POST["btnRegister"] != "") {
		if($_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code'])) {
			$user_add["user_groupid"] = intval(DEFAULT_GROUP_ID);
			switch (emailFaild($_POST["user_mail"])) {
				case 0:
					$emailError = "";
					$user_add["user_mail"] = $_POST["user_mail"];
					break;
				case 1:
					$emailError = "Invalid e-mail address.";
					break;
				case 2:
			}
			if ($emailError == "") {
				$sql = "SELECT count(*) FROM `".TABLE_USERS."` WHERE user_mail = '".$db->escape($_POST["user_mail"])."'";
				$user_mailCount = $db->query_first($sql);
				if ($user_mailCount) {
					if (intval($user_mailCount["count(*)"]) != intval(0)) {
						$emailError = "This email has been used.";
					}
				} else {
					$emailError = "Check email error, please try again";
				}
			}
			$user_add["user_yahoo"] = $_POST["user_yahoo"];
			switch (passwordFaild($_POST["user_pass"], $_POST["user_pass_re"])) {
				case 0:
					$passwordError = "";
					$user_add["user_salt"] = rand(100,999);
					$user_add["user_pass"] = md5(md5($_POST["user_pass"]).$user_add["user_salt"]);
					break;
				case 1:
					$passwordError = "Password is too short.";
					break;
				case 2:
					$passwordError = "Password is too long.";
					break;
				case 3:
					$passwordError = "Password doesn't match.";
					break;
			}
			switch (usernameFaild($_POST["user_name"])) {
				case 0:
					$usernameError = "";
					$user_add["user_name"] = $_POST["user_name"];
					break;
				case 1:
					$usernameError = "Username is too short.";
					break;
				case 2:
					$usernameError = "Username is too long.";
					break;
			}
			if ($_POST["user_reference"] != "") {
				$sql = "SELECT user_id FROM `".TABLE_USERS."` WHERE user_name = '".$db->escape($_POST["user_reference"])."'";
				$user_reference = $db->query_first($sql);
				if ($user_reference) {
					$user_add["user_referenceid"] = $user_reference["user_id"];
					$referenceError = "";
				} else {
					$referenceError = "This username doesn't exist.";
				}
			} else {
				$user_add["user_referenceid"] = "0";
				$referenceError = "";
			}
			if ($usernameError == "") {
				$sql = "SELECT count(*) FROM `".TABLE_USERS."` WHERE user_name = '".$db->escape($_POST["user_name"])."'";
				$user_nameCount = $db->query_first($sql);
				if ($user_nameCount) {
					if (intval($user_nameCount["count(*)"]) != intval(0)) {
						$usernameError = "This username has been used.";
					}
				} else {
					$usernameError = "Check username error, please try again";
				}
			}
			$user_add["user_balance"] = doubleval(DEFAULT_BALANCE);
			$user_add["user_regdate"] = time();
			if ($emailError == "" && $passwordError == "" && $usernameError == "" && $referenceError == "") {
				if($db->query_insert(TABLE_USERS, $user_add)) {
					$registerResult = "<a class=\"span\" href=\"./login.php\"><span class=\"green bold centered\">Welcome ".$user_add["user_name"].", click HERE to login.</span></a>";
					$showForm = true;
				}
				else {
					$registerResult = "<span class=\"red span bold centered\">Register new user error.</span>";
				}
			}
			else {
				$registerResult = "<span class=\"red span bold centered\">Please correct all information.</span>";
			}
			unset($_SESSION['security_code']);
		} else {
			$registerResult = "<span class=\"span\" id=\"eror_register\">Sorry, you have provided an invalid security code.</span>";
		}
	}
?>
				<div id="wraper">
				<div id="cards">
				<div class="spacer-50"></div>

					
<?php
	if ($showForm) {
?>
	<?=$registerResult?>
			<form class="styled-form" name="login" method="post" action="" autocomplete="off">
			<h2>REGISTER</h2>
				

			<label>
            Username:
            <input name="user_name" placeholder="Enter username" type="text" class="formstyle" id="user_name" value="<?=$_POST["user_name"]?>" required>
            </label>
			<?=$usernameError?>

			<label>
            Password:
            <input name="user_pass" placeholder="Enter password" type="password" class="formstyle" id="user_pass" required>
            </label>
			<?=$passwordError?>

			<label>
            Verify Password:
				<input name="user_pass_re" placeholder="Verify password" type="password" class="formstyle" id="user_pass_re" required>
            </label>

			<label>
            JABBER-ID:
				<input name="user_mail" placeholder="Enter jabber" type="text" class="formstyle" id="user_mail" value="<?=$_POST["user_mail"]?>" required>
            </label>
			<?=$emailError?>


			<label class="captcha">
            <img src="./captcha.php?width=100&height=40&characters=5" width="100px" height="40px" />
            <input name="security_code" placeholder="Captcha" type="text" class="captcha"  maxlength="5" required>
            </label>


			<input name="btnRegister" type="submit" class="register-confirm btn btn-normal" id="btnRegister"  value="Register" style="width:100%">
            <label class="rmbrme">
                <label>
                    <input name="remember" type="checkbox" class="checkbox" id="remember" <?php if ($remember) echo "checked ";?>/>
                    Remember Me 
                </label>

                <span style="margin: 5px 0px;"><a href="login.php" class="sm-href">Already registered?</a></span>
            </label>


			<input name="btnCancel" style="width: 100%;" type="button" class="btn btn-del cancel" id="btnCancel" value="Cancel" onclick="window.location='./'">
			<p></p>
			<h5><strong style="color:white;text-align: inherit;">Current Registration Status:<p style="color:green;">Open</p>Current Registration Fees:<p style="color:green;">FREE</p></h5>

			</form>


<?php
	}
?>
				</div>
<?php
}
else {
?>
				<div id="cards">s
					<div class="section_title">USER REGISTER</div>
					<div class="section_content">
					
						<table class="content_table" style="border:none;">
							<tbody>
								<tr>
									<td align="center">
										<span id="eror_register">You have already logged with username [<?=$_SESSION["user_name"]?>], please logout to register new account or click <a href="./">here</a> to go back.</span>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
<?php
}
require("./footer.php");
?>

<style>
.span{
    width: 100%;
    color: var(--white);
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 15px;}

</style>