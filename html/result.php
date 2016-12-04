<?php 
	include("connect.php");
	include("search_book.php");
	session_start();

	function shorten($output, $limit = 15) {
  		$output = htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
  		if (strlen($output) > $limit) {
   	 		$output = substr($output, 0, $limit) . '...<div class="see_more" >see more</div>';
 		}
		echo $output;
	} 
?>
<?php
		$id = $_SESSION['buyer_id'];
		$user_query= "SELECT * from account where account_id='$id'";
	    $user_result=mysqli_query($dbconn, $user_query);
	    $row_session = mysqli_fetch_assoc($user_result);
	    $user_image = $row_session['account_imagepath'];

		if(isset($_GET['ID'])){
			$search = $_GET["ID"];
			$que="SELECT * FROM book_info bi JOIN books b ON bi.book_id=b.book_id WHERE book_name LIKE '%$search%'";
			$result_bookname = mysqli_query($dbconn,$que);

			$que="SELECT * FROM book_info bi JOIN books b ON bi.book_id=b.book_id WHERE book_author LIKE '%$search%'";
			$result_author = mysqli_query($dbconn,$que);

			$que="SELECT * FROM book_info bi JOIN books b ON bi.book_id=b.book_id WHERE book_subject LIKE '%$search%' ";
			$result_subject = mysqli_query($dbconn,$que);

			$que="SELECT * FROM account WHERE account_name LIKE '%$search%' and account_id != '$id'";
			$result_account = mysqli_query($dbconn,$que);

		} else {
			echo "Not found";
		}	?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="CMSC 128 Lab Sec. 2">
	<meta name="description" content="Sell, buy, and trade books with your schoolmates.">
	<meta name="keywords" content="Book, Books, Trade Book, Sell Book, Buy Book">
	<title> Search Result </title>

	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/normalize.css">
	<link rel="stylesheet" type="text/css" href="../css/library_style.css">
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
			<h2 id="tag_results">Search results for "<?php echo $search ?>"...</h2>
	<div class=" shelf_section well well-sm " >

	<h1>Result by Book Title</h1>
	<?php
		if(mysqli_num_rows($result_bookname)>0){ 
				while($row=mysqli_fetch_assoc($result_bookname)){ 
					$id = $row['book_id'];?>
					<a class="bookshelf_book_container" href="Public_book_info.php?id=<?=$row['book_id']?>">
						<content class="bookshelf_book"><img title="Upload Image" alt="Upload Image" height="225" width="150" class="" src="<?php echo $row['book_imagepath']; ?>">
						</content>
						<label for="book_title" id="book_title"> <?=shorten($row['book_name']);?> </label>
					</a>
		<?php	} 
		} ?>

	</div>

	<div class=" shelf_section well well-sm " >

	<h1>Result by Book Author</h1>
	<?php
		if(mysqli_num_rows($result_author)>0){ 
				while($row=mysqli_fetch_assoc($result_author)){ 
					$id = $row['book_id'];?>
					<a class="bookshelf_book_container" href="Public_book_info.php?id=<?=$row['book_id']?>">
						<content class="bookshelf_book"><img title="Upload Image" alt="Upload Image" height="225" width="150" class="" src="<?php echo $row['book_imagepath']; ?>">
						</content>
						<label for="book_title" id="book_title"> <?=shorten($row['book_name']);?> </label>
					</a>
		<?php	} 
		} ?>

	</div>

	<div class=" shelf_section well well-sm " >

	<h1>Result by Book Subject</h1>
	<?php
		if(mysqli_num_rows($result_subject)>0){ 
				while($row=mysqli_fetch_assoc($result_subject)){ 
					$id = $row['book_id'];?>
					<a class="bookshelf_book_container" href="Public_book_info.php?id=<?=$row['book_id']?>">
						<content class="bookshelf_book"><img title="Upload Image" alt="Upload Image" height="225" width="150" class="" src="<?php echo $row['book_imagepath']; ?>">
						</content>
						<label for="book_title" id="book_title"> <?=shorten($row['book_name']);?> </label>
					</a>
		<?php	} 
		} ?>

	</div>


	<div class=" shelf_section well well-sm " >

	<h1>Result by Bookshare Users</h1>
	<?php
		if(mysqli_num_rows($result_account)>0){ 
				while($row=mysqli_fetch_assoc($result_account)){ 
					?>
					<label for='seller' class="info1_items"><a href="<?php echo "Seller_profile.php?seller=".$row["account_id"];?>"><?php echo $row["account_name"] ?></a></label>
		<?php	} 
		} ?>

	</div>



	</div>

	<content id="prev_next">
	 	<a href=" " id="prev" ><< Prev </a> &nbsp;|&nbsp;
	 	<a href=" " id="next" >Next >> </a>
	</content>

	</div>	
		<footer>
			<p>A.Y. 2016-2017 Bookshare | &copy;CMSC 128 Lab Sec. 2 |  2016</p>
		</footer>
	</div>
</body>
</html>
