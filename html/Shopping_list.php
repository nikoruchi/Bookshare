
<?php
	include("connect.php");
	include("search_book.php");
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="CMSC 128 Lab Sec. 2">
	<meta name="description" content="Sell, buy, and trade books with your schoolmates.">
	<meta name="keywords" content="Book, Books, Trade Book, Sell Book, Buy Book">
	<title>Shopping List</title>

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

	
		<h1 id="bookshelf">Shopping List</h1>
		<div class=" list_section well well-sm" > 

		<?php
	//		$select_query = "SELECT book_name, account_name, book_price from books join account on books.account_id=account.account_id join cart on cart.book_id=books.book_id";
	//		$result = mysqli_query($dbconn, $select_query);

	//		if(mysqli_num_rows($result)>0){
	//			while($row=mysqli_fetch_assoc($result)){?>


			<div class="list_content">
          		<img id="thumbnail" src="../images/default.jpg">
          		<p id="content">
          			<strong><?php echo "450"?></strong>
          			<label id="bookname"><?php echo "BOOK TITLE"?></label>
					<label id="accname"><?php echo "ACC NAME"?></label>
          		</p>
      		</div>
      		<div class="list_content">
          		<img id="thumbnail" src="../images/default.jpg">
          		<p id="content">
          			<strong><?php echo "450"?></strong>
          			<label id="bookname"><?php echo "BOOK TITLE"?></label>
					<label id="accname"><?php echo "ACC NAME"?></label>
          		</p>
      		</div>

				<!-- <table>
					<tr>
						<td> <img id="thumbnail" src="../images/default.jpg"></td> 
						<td><?php echo "bookname"?></td>
						<td><?php echo "USER"?></td>
						<td><?php echo "price"?></td>

						<!-- <td><?php echo $row['book_name']?></td>
						<td><?php echo $row['account_name']?></td>
						<td><?php echo $row['book_price']?></td> -->
					<!-- </tr> -->
				<!-- </table> -->
			
				<?php
			//	}
			//}

			//$subtotal = "SELECT sum(book_price) as Price from books join cart on cart.book_id=books.book_id";
			//$retresult = mysqli_query($dbconn,$subtotal);
			//if(mysqli_num_rows($retresult)>0){
			//	while($row=mysqli_fetch_assoc($retresult)){
		//			$price_result = $row['Price'];
		//		?>


				<div class="foot">Subtotal: <content><?php echo "Price_result"?></content></div>
			<?php
		//		}
		//	}?>
			<form id="proceed"> <!-- Authentication will be a nightmare. Probably need PHP sessions or something -->
				<p><a href="" data-toggle="modal" data-target="#myModalP">Checkout</a></p>
				<!-- cancel link here-->
			</form>
	</div>

<!-- CHECKOUT MODAL -->
  <div class="modal fade" id="myModalP" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
      <form method="post" action="<?php $_PHP_SELF; ?>" >
        <div class="modal-header">
          <h4 class="modal-title">Your request has been sent</h4>
        </div>
        <div class="modal-body">
			Please wait for the book owner/s to contact you with details.
        </div>
        <div class="modal-footer">
            <form method="post" action="<?php $_PHP_SELF; ?>" >
            	<a href="Checkout.php"><button class="btn btn-success">Proceed</button></a>
			</form>
        </div>
        </form>
      </div>
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
