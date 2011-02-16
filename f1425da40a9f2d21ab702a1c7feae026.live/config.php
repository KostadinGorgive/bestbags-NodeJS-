<?php
ob_start(); //Turns on output buffering 

$timezone = date_default_timezone_set("Europe/London");

$con = mysqli_connect("mysql5031.site4now.net", "a7a9a0_major", "migliormajor987", "db_a7a9a0_major"); //Connection variable

if(mysqli_connect_errno()) 
{
	echo "Failed to connect: " . mysqli_connect_errno();
}

?>