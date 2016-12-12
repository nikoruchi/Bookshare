	<?php
		include("connect.php");
		include("search_book.php");
		session_start(); 
	$buyer_id = $_SESSION['buyer_id'];
	$user_query= "SELECT * from account where account_id='$buyer_id'";
    $user_result=mysqli_query($dbconn, $user_query);
    $row_session = mysqli_fetch_assoc($user_result);
    $user_image = $row_session['account_imagepath'];
	?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="CMSC 128 Lab Sec. 2">
	<meta name="description" content="Sell, buy, and trade books with your schoolmates.">
	<meta name="keywords" content="Book, Books, Trade Book, Sell Book, Buy Book">
	<title>Bookmark List</title>

	<link rel="shortcut icon" href="../images/official_logo.png">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/shoppinglist.css">
	<script src="../js/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/normalize.css">
  <script src="../js/modal.js"></script>
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
            			<label for="username"><?php echo $_SESSION['username'];?></label>
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

	
		<h1 id="bookshelf">Bookmarks</h1>
		<div class=" list_section well well-sm" > 

		<?php
			$select_query = "SELECT * from books join account on books.account_id=account.account_id join bookmarks on bookmarks.book_id=books.book_id WHERE bookmarks.buyer_id='$buyer_id'";
			$result = mysqli_query($dbconn, $select_query);
			if(mysqli_num_rows($result)>0){
				while($row=mysqli_fetch_assoc($result)){?>


			<div class="list_content">
				<a href="Public_book_info.php?id=<?php echo $row['book_id']?>">
          		<img id="thumbnail" src=" <?php echo $row['book_imagepath']?>">
          		</a>
          		<p id="content">
          			<strong>Php<?php echo $row['book_price']?></strong>
          			<label id="bookname"><?php echo $row['book_name']?></label>
					<label id="accname"><?php echo $row['account_name']?></label>
          		</p>
          		<div class="proceed">
	      		<form >
	      				<a id="action1"  class="btn btn-primary" href="Add_to_Cart.php?id=<?php echo $row['book_id']?>">+Add to Cart</a>
	      				<a id="action2"  class="btn btn-primary" href="Delete_Bookmark.php?id=<?php echo $row['book_id']?>">Remove</a>
				</form>
			</div>
			</div>
				<?php
				}
			} ?>
		</div>
		
	</div>

<!-- DON'T -->
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