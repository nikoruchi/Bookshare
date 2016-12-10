<!DOCTYPE html>
<body>
	<?php
		include("connect.php");
		session_start();
		
		$book_id = $_GET['id'];
		$buyer_id = $_SESSION['buyer_id'];
		$query = "DELETE FROM cart WHERE book_id='$book_id' AND buyer_id='$buyer_id'";
		mysqli_query($dbconn,$query);
		header("Location:Shopping_list.php");
		?>
	</form>
</body>
</html>