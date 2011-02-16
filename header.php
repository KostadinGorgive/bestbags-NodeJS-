<?php
session_start();
require("./includes/config.inc.php");
$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];
if (isset($_POST["txtUser"]) && isset($_POST["txtPass"]) && isset($_POST["btnLogin"]))
{
	if($_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code'])) {
		$remember = isset($_POST["remember"]);
		$loginError = confirmUser($_POST["txtUser"], $_POST["txtPass"], PER_UNACTIVATE, $remember);
		unset($_SESSION['security_code']);
	} else {
		$loginError = 4;
	}
	$checkLogin = ($loginError == 0);
}
else
{
	$checkLogin = checkLogin(PER_UNACTIVATE);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Major Carder's Palace</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<meta content="index, follow" name="robots" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="./images/icon.jpg" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="./styles/select2.min.css" />
		<link rel="stylesheet" type="text/css" href="./styles/main.css" />
		<link rel="stylesheet" type="text/css" href="./styles/superfish.css" />
		<script type="text/javascript" src="./js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="./js/jquery.popupWindow.js"></script>
		<script type="text/javascript" src="./js/select2.min.js"></script>
		<script type="text/javascript" src="./js/main.js" ></script>
		<script type="text/javascript" src="./js/superfish.js"></script>
		<script type="text/javascript">

		// initialise plugins
		jQuery(function(){
			jQuery('ul.sf-menu').superfish();
		});

		</script>
	</head>

	<body>
<?php
if ($checkLogin) {
	$sql = "SELECT * FROM `".TABLE_USERS."` WHERE user_id = '".$_SESSION["user_id"]."'";
	$user_info = $db->query_first($sql);
	if (!$user_info) {
		$getinfoError = "<span class=\"red bold centered\">Get user information error, please try again</span>";
	}
?>
			<div class="navbar" id="menubar">
			    
				<div class="nav-items">
					<a href="./" class="<?php if (basename($_SERVER['PHP_SELF']) == 'index.php'){ echo 'nav-active';} ?>"><i class="fa fa-globe style="font-size:24px"></i> News</a>
					<a href="./cards.php?stagnant=false" class="<?php if (basename($_SERVER['PHP_SELF']) == 'cards.php'){ echo 'nav-active';} ?>"><i class="fa fa-credit-card" style="font-size:14px"></i> Cards</a>
					<?php
					
					$user_id = $_SESSION["user_id"];

                    $showuser = mysqli_query($conn, "SELECT * FROM users WHERE `user_id`='$user_id';");
                    $rowUser = mysqli_fetch_array($showuser);
                    $user_balance = $rowUser['user_balance'];
                    
                    if($rowUser['seller'] == '1'){
                        ?>
                        <a href="./seller_dashboard.php"><i class="fa fa-history" style="font-size:14px"></i> Seller Panel</a>
                    <?php }
					
					?>
                    
					<a href="./mycards.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'mycards.php'){ echo 'nav-active';} ?>"><i class="fa fa-history" style="font-size:14px"></i> History</a>
					<a href="./deposit.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'deposit.php'){ echo 'nav-active';} ?>"><i class="fa fa-plus" style="font-size:14px"></i> Deposit</a>
					<a href="./support.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'support.php'){ echo 'nav-active';} ?>"><i class="fa fa-comments" style="font-size:14px"></i> Support</a>
					<a href="./myreports.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'myreports.php'){ echo 'nav-active';} ?>"><i class="fa fa-ticket" style="font-size:14px"></i> Tickets</a><a href="./bin.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'bin.php'){ echo 'nav-active';} ?>"><i class="fa fa-history" style="font-size:14px"></i> BIN CHECKER</a>
					<a href="./card-checker.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'card-checker.php'){ echo 'nav-active';} ?>"><i class="fa fa-history" style="font-size:14px"></i> CARD CHECKER</a>
					<a href="./bin_request.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'bin_request.php'){ echo 'nav-active';} ?>"><i class="fa fa-history" style="font-size:14px"></i> BIN REQUEST</a>
					<a href="./faq.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'faq.php'){ echo 'nav-active';} ?>"><i class="fa fa-question-circle" style="font-size:14px"></i> FAQ</a>
					<div class="account-info<?php if (basename($_SERVER['PHP_SELF']) == 'myaccount.php'){ echo ' nav-active';} ?>
													<?php if (basename($_SERVER['PHP_SELF']) == 'mycheck.php'){ echo ' nav-active';} ?>">
						<i class="fa fa-user" style="font-size:14px"></i> Account Panel
						<div class="show" style="display:none;">
							<a href="./mycheck.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'mycheck.php'){ echo 'nav-active';} ?>">My checks</a>
							<a href="./myaccount.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'myaccount.php'){ echo 'nav-active';} ?>">Account Information</a>
						</div>
					</div>
				</div>

				<div id="shopping_cart" class="nav-items">
												<?php
	if ($user_info["user_balance"] <= -1) {
?>
<a class="<?php if (basename($_SERVER['PHP_SELF']) == 'deposit.php') ?>"><p style="color:#f72b50;"><i  class="fa fa-warning" style="font-size:14px;color:#f72b50;"></i> INACTIVE ACCOUNT <i class="fa fa-warning" style="font-size:14px;color:#f72b50;"></i></p></a>

<?php
	}
?>
	<?php
	if ($user_info["user_balance"] <= -1) {
?>
<a href="deposit.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'deposit.php'){ echo 'nav-active';} ?>"><p style="color:white;><i class="fa fa-plus" style="font-size:14px"></i> Balance: <h style="color:white;"><?=number_format($user_info["user_balance"], 2, '.', '')?>$</p></a>

<?php
	}
?>
<?php
	if ($user_info["user_balance"] > -1) {
?>
<a href="deposit.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'deposit.php'){ echo 'nav-active';} ?>"><p style="color:white;><i class="fa fa-plus" style="font-size:14px"></i> Balance: <h style="color:white;"><?=number_format($user_info["user_balance"], 2, '.', '')?>$</p></a>

<?php
	}
?>


					<a href="cart.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'cart.php'){ echo 'nav-active';} ?>"><p><i style="font-size:18px" class="fa">&#xf07a;</i> <?=count($_SESSION["shopping_card"])?> Item(s) </p></a>
					<a href="./logout.php"><i class="fa fa-sign-out style="font-size:30px"></i> SIGN OUT</a>


				</div>

				

			</div>
<?php
}
?>
			<div id="main">
			    <!-- Clarity tracking code for https://majorcc.shop -->
<script>
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i+"?ref=bwt";
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "938nen6hx3");
</script>