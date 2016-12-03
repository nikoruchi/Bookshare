<!DOCTYPE html>
<body>
	<?php
		include("connect.php");
		session_start();
		
		$book_id = $_GET['id'];
		$buyer_id = $_SESSION['buyer_id'];
		$query = "DELETE FROM bookmarks WHERE book_id='$book_id' AND buyer_id='$buyer_id'";
		mysqli_query($dbconn,$query);
		header("Location:View_Bookmarks.php");
		?>
	</form>
</body>
</html>