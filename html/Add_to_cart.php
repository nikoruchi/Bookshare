<?php
	include("connect.php");
	include("search_book.php");
	session_start();
	$buyer_id = $_SESSION['buyer_id'];
	date_default_timezone_set('Asia/Manila');
	$date=date("Y-m-d");
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$quer = "SELECT * FROM books b JOIN book_info bi ON b.book_id=bi.book_id WHERE b.book_id='$id'";
		$result = mysqli_query($dbconn,$quer);
			if(mysqli_num_rows($result)>0){ 
				while($row=mysqli_fetch_assoc($result)){ 
					$bname = $row['book_name'];
					$bauthor = $row['book_author'];
					$bdetails = $row['book_details'];
					$bedition = $row['book_edition'];
					$bprice = $row['book_price'];
					$bdesc = $row['book_desc'];
					$seller = $row['account_id'];
					$category = $row['book_subject'];
					$imagepath = $row['book_imagepath'];
				}
			}
	} else{
		msg("cant add to cart.");
	}
	
	$sqlee = "SELECT * FROM cart WHERE seller_id='$seller' AND book_id='$id' AND buyer_id='$buyer_id'";
	$sqle = mysqli_query($dbconn,$sqlee);
	if(mysqli_num_rows($sqle)>0){
		msg("you already add this book in your cart"); 
	} else {
		$sql = "INSERT INTO cart (seller_id, book_id, buyer_id, date, status) VALUES ('$seller', '$id', '$buyer_id','$date', '')";
		$sqlresult = mysqli_query($dbconn,$sql);
		if($sqlresult){
			$query = "DELETE FROM bookmarks WHERE book_id='$id' AND buyer_id='$buyer_id'";
			if(mysqli_query($dbconn,$query)){
				header("Location:Shopping_list.php");
			}  else {
				msg("unable to add book.");
			}
		} 
	}

	header("Location:View_bookmarks.php");
	
	function msg($mess){?>    
    <p><?=$mess;?></p>
    <?php }
?>