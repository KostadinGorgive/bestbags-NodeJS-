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
		<link rel="stylesheet" type="text/css" href="./styles/main.css" />
		<link rel="stylesheet" type="text/css" href="./styles/superfish.css" />
		<script type="text/javascript" src="./js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="./js/jquery.popupWindow.js"></script>
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