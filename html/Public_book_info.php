<?php
	include("connect.php");
	include("search_book.php");
	session_start();

	date_default_timezone_set('Asia/Manila');
	$date=date("Y-m-d");

	$buyer_id = $_SESSION['buyer_id'];
	$user_query= "SELECT * from account where account_id='$buyer_id'";
    $user_result=mysqli_query($dbconn, $user_query);
    $row_session = mysqli_fetch_assoc($user_result);
    $user_image = $row_session['account_imagepath'];

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
					$bpages = $row['book_pages'];
					$bquality = $row['book_quality'];
					$seller = $row['account_id'];
					$category = $row['book_subject'];
					$imagepath = $row['book_imagepath'];
				}
			}
	} else{
		header("Location:Library.php");
	}

	$seller1="SELECT * FROM account WHERE account_id='$seller'";
	$seller11=mysqli_query($dbconn,$seller1);
	$row=mysqli_fetch_assoc($seller11);
	$sellername=$row["account_name"];


	if(isset($_POST['add_to_cart'])){
		$sql = "INSERT INTO cart (seller_id, book_id, buyer_id, date) VALUES ('$seller', '$id', '$buyer_id','$date')";
		$sqlresult = mysqli_query($dbconn,$sql);
		if($sqlresult){
			header("Location:Public_book_info.php?id=$id");
		} else { ?>
			<script>
				function myfuction(){
					alert("Can't add book to the cart.");
				}
			</script>
<?php	}
		 
	}

	if(isset($_POST['remove_from_cart'])){
		$sql = "DELETE FROM cart WHERE book_id = '$id'";
		$sqlresult = mysqli_query($dbconn,$sql);
		if($sqlresult){
			header("Refresh:0");
		} else { ?>
			<script>
				function myfuction(){
					alert("Can't remove book from the cart.");
				}
			</script>
<?php	}
		 
	}

?> 

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="CMSC 128 Lab Sec. 2">
	<meta name="description" content="Sell, buy, and trade books with your schoolmates.">
	<meta name="keywords" content="Book, Books, Trade Book, Sell Book, Buy Book">
	<title> Public Book Info </title>

	<link rel="shortcut icon" href="../images/official_logo.png">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/normalize.css">
	<script src="../js/jquery.min.js"></script>
</head>
<body>
	<div class="wrapper">
	<header>
		<nav>
			<ul>
            <li class="nav_lib">
            	<div>
           			<a href="Library.php">
           				<img src="../images/official_logo.png" title="Library" alt="Library" height="50" width="50" id="logo">
           				<label for="library" id="logolabel">Library</label>
           			</a>
           		</div>
            </li>
            <li class="nav_srch">
            	<span class="col-xs-4">            	
            		<form method="post" action = "<?php $_PHP_SELF; ?>">
						<input type="search" name="search" placeholder="Search..." class="form-control-srch" id="noborder">
						<input type="submit" name="submit" value="GO" class="btn btn-success">
					</form>
				</span>
            </li>
            <li class="nav_prof">
            	<div>
            		<a href="Profile.php">
            			<img src="<?php echo $user_image;?>" title="Profile" alt="Profile" height="40" width="40" id="logo2">
            			<label for="username"><?php echo $_SESSION['username'];?> </label>
            		</a>
            	</div>
            </li>
            <li class="nav_cart">
              <div>
                <span id="notification_count"></span>
                <a href="Shopping_list.php" id="notificationLink" onclick = "return getNotification()">
                  <img src="../images/cart.png" alt="Shopping List" title="Go to your Shopping List" height="40" width="40" >
                </a>
              </div>
            </li>
            <li class="nav_mark">
              <div>
                <a href="View_bookmarks.php">
                  <img src="../images/logo_bookmark.png" alt="Bookmarks" title="View your bookmarks" height="40" width="40" id="logo3">
                </a>
              </div>
            </li>
            <li class="nav_set">
            	<div>
            		<label for="settings">
            			<a href="Settings.php">Settings</a> |
            		</label>
            	</div>
            </li>
           	<li class="nav_log">
           		<div>
           		<a href="index.php">
           			<label for="logout" id="logout">Log-out</label>
           		</a>
           		</div>
           	</li>
        	</ul>
		</nav>
	</header>
	<div class="container">
	
	 <div class=" info_section well well-sm" > 
	 	<div class="bookmark_container">
	 	<!-- Public_book_info.php?id=<?php echo $id; ?>" > -->
	 		<?php 
	 		$check = "SELECT * FROM bookmarks WHERE book_id='$id' AND buyer_id='$buyer_id'";
	 		$checkres = mysqli_query($dbconn,$check);
	 		if(mysqli_num_rows($checkres)>0){ ?>
	 			<a name="unbookmark" href="Bookmark.php?id=<?php echo $id?>" ><img src="../images/bookmark_add.png" title="Remove Bookmark" alt="Remove Bookmark" height="30" width="35" id="edit_icon" onclick="edit_menu()" class=" bookmarkadd_btn" > </a> <!--ICON IF BOOK IS IN BOOKMARKS -->
	 <?php  } else { ?>
				<img src="../images/bookmark.png" title="Bookmark this Book" alt="Bookmark this Book" height="30" width="35" id="edit_icon" onclick="edit_menu()" class=" bookmark_btn"> <!--ICON -->
				<a name="bookmark" href="Bookmark.php?id=<?php echo $id?>" >
				<img src="../images/bookmark_hover.png" title="Bookmark this Book" alt="Bookmark this Book" height="30" width="35" id="edit_icon" onclick="edit_menu()" class=" bookmarkhover_btn"> </a> <!-- ICON ON HOVER -->
     <?php  } ?>
	 	</div>
	 	
	  <div class="info">
		<div class="book_image_container">
			<img id="book_pic" src="<?php echo $imagepath ?>"  width="200" height="275" />
		</div>
		<div class="book_info1" id="book_info1_label">
			<label for='price' class="info1_items">
				Php <?php echo $bprice ?>
			</label>
		</div>
		<div class="book_info1a">
 			<label for="category" id="book_info1a_label"> Course Category: </label>
			<label for='category' class="info1_items"><?php echo $category ?></label>
			<content id="extra_details">
				<label id="book_info1a_label" for='quality'>Quality: </label>
				<p><?php echo $bquality ?></p>
			</content>
			<content id="extra_details">
				<label id="book_info1a_label" for='pages'>No. of Pages: </label>
				<label><?php echo $bpages ?></label> 
			</content>
			<label for="seller" id="book_info1a_label"> Seller: </label>
			<label for='seller' class="info1_items"><a href="<?php if($buyer_id!=$seller){echo "Seller_profile.php?seller=".$seller;}else{echo "Profile.php?id=".$buyer_id;
				}?>"><?php echo $sellername ?></a></label>
		</div>
		<div class="book_info2">
			<label for='title' id="info_label_title"> 
				<h2> <?php echo $bname ?> </h2>
			</label>
			<content class="info_container" id="info_label_title"> 
				<label> <?php 
					if ($bedition==''){$bedition="Unknown";} 
					echo $bedition; ?> Edition
				</label>
			</content>
			<label for='author' id="info_label">Author/s: </label>
			<content class="info_container"> <?php echo $bauthor ?> </content>
			<label for='description' id="info_label">Description: </label>
			<content class="info_container"> <?php echo $bdesc ?> </content>
			<label for='details' id="info_label">Details: </label>
			<content class="info_container"> <?php echo $bdetails ?> </content>
		</div>
	  </div>

	  <div class="add_cart">
	  	<form action="<?php $_PHP_SELF; ?>" method="post">
	  	<?php
	  		$sqlee = "SELECT * FROM cart WHERE seller_id='$seller' AND book_id='$id' AND buyer_id='$buyer_id'";
			$sqle = mysqli_query($dbconn,$sqlee);
			if(mysqli_num_rows($sqle)==0) { ?>
				<button name="add_to_cart"  class="btn btn-primary">+Add to Cart</button> 
	<?php	} else {	  	?>
				<button name="remove_from_cart" class="btn btn-danger" style="margin-left: -25px">-Remove from Cart</button>
	<?php	} ?>
		</form>
	  </div>

	 </div>	

	</div>
		<footer>
			<p>A.Y. 2016-2017 Bookshare | &copy;CMSC 128 Lab Sec. 2 |  2016</p>
		</footer>
	</div>
</body>
</html>

<script type="text/javascript" charset="utf-8">
function addmsg(type, msg){
  $('#notification_count').html(msg);
}
function waitForMsg(){
  var id = <?php echo json_encode($buyer_id);?>;  
  $.ajax({
  type: "GET",
  url: "shopping.php?id="+id,
  async: true,
  cache: false,
  timeout:50000,
 
  success: function(data){
    addmsg("new", data);
    setTimeout(
      waitForMsg,
      1000
    );
  },
  error: function(XMLHttpRequest, textStatus, errorThrown){
    addmsg("error", textStatus + " (" + errorThrown + ")");
    setTimeout(
      waitForMsg,
      15000);
    }
  });
};
 
$(document).ready(function(){
  waitForMsg();
});
</script>