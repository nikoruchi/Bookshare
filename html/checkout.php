<?php
	include("connect.php");
	session_start();

	// if (!isset($_SESSION['account_id'])){ 
	// 	header('Location:./login.php');
	// }
	date_default_timezone_set('Asia/Manila');
	$date=date("Y-m-d");
	$buyer_id=$_SESSION['buyer_id'];
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		$query = "SELECT * FROM cart WHERE cart.buyer_id='$buyer_id' AND date='$date'"; /*TODO: id*/
		$result = mysqli_query($dbconn, $query) or die('Could not retrieve cart items: ' . mysqli_error($dbconn));
		//$sql = [];
		while ($row = mysqli_fetch_assoc($result)) {
			/* TODO
			finalize column names 
			function with purchase notification template
			*/
			$seller = $row['seller_id'];
			$book = $row['book_id'];
			$cart = $row['cart_no'];
			// $message = mysqli_real_escape_string($dbconn, purchase_msg($buyer_id, $row['book_name']));
			//$sql = array("$buyer_id", "$recipient", "$message");
			$query = "UPDATE cart SET status='bought' WHERE cart_no='$cart'";
			mysqli_query($dbconn,$query);
			$sql="INSERT INTO messages (message_id, seller_id, buyer_id, book_id, date) VALUES (3,'$seller','$buyer_id','$book','$date')";
			mysqli_query($dbconn,$sql);
		}
	}

	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="CMSC 128 Lab Sec. 2">
	<meta name="description" content="Sell, buy, and trade books with your schoolmates.">
	<meta name="keywords" content="Book, Books, Trade Book, Sell Book, Buy Book">
	<meta http-equiv="refresh" content="3;url=./Profile.php" /> <!-- placeholder. don't know where to redirect yet -->
	<title> Checkout </title>

	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<!-- GONE -->
</body>
</html>
