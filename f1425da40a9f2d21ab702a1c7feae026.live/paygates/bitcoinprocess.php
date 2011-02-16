<?php
session_start();
include_once "config.php";
require("../includes/config.inc.php");
if (checkLogin(PER_USER)) {
	if ($_POST["btc_amnt"] != "" && doubleval($_POST["btc_amnt"]) >= doubleval($db_config["paygate_minimum"])) {
        include_once "config.php";
        include_once "functions.php";
        
        if(!isset($_GET['btc_amnt'])){
            // If no ID found, exit
            exit();
        }
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        
        $price = getPrice($id);
        
        $code = createInvoice($id, $price);
        
        echo "<script>window.location='invoice.php?code=".$code."'</script>";
        ?>
        <html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitcoin store</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Products -->
    <main>
        <div class="row">
            <div class="product-hold">
                <?php
                // Get and display all products
                $sql = "SELECT * FROM `products` ORDER BY `id` DESC";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <div class="product">
                        <div class="card" style="width: 95%;margin:0 auto;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted">$<?php echo $row['price']; ?></h6>
                                <p class="card-text"><?php echo $row['description'] ?></p>
                                <a href="buy.php?id=<?php echo $row['id']; ?>" class="card-link">Buy now</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </main>
<?php
	}
	else {
		header("Location: ../deposit.php");
	}
}
else {
	header("Location: ../login.php");
}
exit(0);
?>