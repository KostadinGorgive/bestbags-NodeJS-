
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

			<div class="navbar" id="menubar">
			    
				<div class="nav-items">
					<a href="./seller_dashboard.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'seller_dashboard.php'){ echo 'nav-active';} ?>"><i class="fa fa-globe style="font-size:24px"></i> Dashboard</a>
					<a href="./seller_new.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'seller_new.php'){ echo 'nav-active';} ?>"><i class="fa fa-plus" style="font-size:14px"></i> Insert</a>
					<a href="./seller_db.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'seller_db.php'){ echo 'nav-active';} ?>"><i class="fa fa-plus" style="font-size:14px"></i> Databases</a>
					<a href="./seller_cards.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'seller_cards.php'){ echo 'nav-active';} ?>"><i class="fa fa-credit-card" style="font-size:14px"></i> My Cards</a>
					<a href="./seller_sales.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'seller_sales.php'){ echo 'nav-active';} ?>"><i class="fa fa-history" style="font-size:14px"></i> My Sales</a>
					<a href="./seller_bin_request.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'seller_bin_request.php'){ echo 'nav-active';} ?>"><i class="fa fa-history" style="font-size:14px"></i> Bin Requests</a>
					<a href="./seller_accepted_bin_request.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'seller_accepted_bin_request.php'){ echo 'nav-active';} ?>"><i class="fa fa-history" style="font-size:14px"></i> Accepted Bin Requests</a>
				</div>

                <div class="nav-items">
                                <a href="deposit.php"><p style="color:white;><i class="fa fa-plus" style="font-size:14px"></i> Seller: <h style="color:white;"><?=number_format($seller_balance, 2, '.', '')?>$</p></a>
                <a href="deposit.php"><p style="color:white;><i class="fa fa-plus" style="font-size:14px"></i> Balance: <h style="color:white;"><?=number_format($user_balance, 2, '.', '')?>$</p></a>


				    <a href="./logout.php"><i class="fa fa-sign-out style="font-size:30px"></i> SIGN OUT</a>
                </div>

				

				

			</div>

			