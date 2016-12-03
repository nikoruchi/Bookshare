<?php
	include("connect.php");
	session_start();

	// if (!isset($_SESSION['account_id'])){ 
	// 	header('Location:./login.php');
	// }

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		$query = "select * from books where book_id in (select book_id from cart where account_id=$_SESSION[id])"; /*TODO: id*/
		$result = mysqli_query($conn, $query)
			or die('Could not retrieve cart items: ' . mysqli_error($conn));
		$sql = [];
		while ($row = mysqli_fetch_assoc($result)) {
			/* TODO
			finalize column names
			function with purchase notification template
			*/
			$sql[] = "(\"$_SESSION[account_id]\", \"$row[account_id]\", \"".mysqli_real_escape_string($conn, purchase_msg($_SESSION['account_id'], $row['book_name'])).'")';
		}
		mysqli_query($conn, 'INSERT INTO messages (sender, recipient, message) VALUES '.implode(',', $sql));

		mysqli_close($conn);
	}

	function purchase_msg($buyer, $title) {
		return $buyer.' wants to buy "'.$title.'" from you.';
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="CMSC 128 Lab Sec. 2">
	<meta name="description" content="Sell, buy, and trade books with your schoolmates.">
	<meta name="keywords" content="Book, Books, Trade Book, Sell Book, Buy Book">
	<meta http-equiv="refresh" content="3;url=./Market.htm" /> <!-- placeholder. don't know where to redirect yet -->
	<title> Market </title>

	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<!-- GONE -->
</body>
</html>
