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
			$buyer_id = $_SESSION['buyer_id'];
			$select_query = "SELECT * from books join account on books.account_id=account.account_id join cart on cart.book_id=books.book_id WHERE cart.buyer_id='$buyer_id' AND date='$date'";
			$result = mysqli_query($dbconn, $select_query);
			if(mysqli_num_rows($result)>0){
				while($row=mysqli_fetch_assoc($result)){?>


			<div class="list_content">
          		<img id="thumbnail" src=" <?php echo $row['book_imagepath']?>">
          		<p id="content">
          			<strong>Php<?php echo $row['book_price']?></strong>
          			<label id="bookname"><?php echo $row['book_name']?></label>
					<label id="accname"><?php echo $row['account_name']?></label>
          		</p>
      		</div>
      		
				
			
				<?php
				}
			}
			$subtotal = "SELECT sum(book_price) as Price from books join cart on cart.book_id=books.book_id WHERE cart.buyer_id='$buyer_id'";
			$retresult = mysqli_query($dbconn,$subtotal);
			if(mysqli_num_rows($retresult)>0){
				while($row=mysqli_fetch_assoc($retresult)){
					$price_result = $row['Price'];
				}
				?>


				<div class="foot">Subtotal: <content>Php<?php echo $price_result?></content></div>
	<?php 	} ?>
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
        <div class="modal-header">
          <h4 class="modal-title">Your request has been sent</h4>
        </div>
        <div class="modal-body">
			Please wait for the book owner/s to contact you with details.
        </div>
        <div class="modal-footer">
            <form method="post" action="checkout.php" >
            	<a href="Checkout.php"><button class="btn btn-success">Proceed</button></a>
			</form>
        </div>
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
Contact GitHub API Training Shop Blog About
© 2016 GitHub, Inc. Terms Privacy Security Status Help