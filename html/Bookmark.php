<?php
	include("connect.php");
	session_start();
	$book_id = $_GET['id'];
	$buyer_id = $_SESSION['buyer_id'];

	$check = "SELECT * FROM bookmarks WHERE book_id='$book_id' AND buyer_id='$buyer_id'";
	$checkres = mysqli_query($dbconn,$check);

	if(mysqli_num_rows($checkres)>0){
		$query = "DELETE FROM bookmarks WHERE book_id='$book_id' AND buyer_id='$buyer_id'";
	} else {
		$query = "INSERT into bookmarks (`book_id`,`buyer_id`) VALUES ('$book_id','$buyer_id')";
	}

	mysqli_query($dbconn,$query);
	header("Location:Public_book_info.php?id=$book_id");
?>