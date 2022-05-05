<?php
	ob_start();
	session_start();
	

	$timezone = date_default_timezone_set("Asia/Ho_Chi_Minh");

	$con = mysqli_connect("localhost", "root", "", "spotify") or die ("Failed to connect");

	
?>