<?php
	include("connect.php");
	session_start();
	?>

<?php

	$id = $_SESSION['buyer_id'];
	$user_query= "SELECT * from account where account_id='$id'";
    $user_result=mysqli_query($dbconn, $user_query);
    $row_session = mysqli_fetch_assoc($user_result);
    $user_image = $row_session['account_imagepath'];

  $bookname_shelf = "SELECT * from books as B join account as A on B.account_id=A.account_id";
  $shelf_result=mysqli_query($dbconn, $bookname_shelf);
  $numbooks=mysqli_num_rows($shelf_result);
?>

<?php function shorten($output, $limit = 15) {
  $output = htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
  if (strlen($output) > $limit) {
    $output = substr($output, 0, $limit) . '...<div class="see_more" >see more</div>';
  }

  echo $output;
} 
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="CMSC 128 Lab Sec. 2">
	<meta name="description" content="Sell, buy, and trade books with your schoolmates.">
	<meta name="keywords" content="Book, Books, Trade Book, Sell Book, Buy Book">
	<title> Bookshelf </title>

	<link rel="shortcut icon" href="../images/official_logo.png">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/normalize.css">
</head>
<body>
	<div class="wrapper">
		<header>
		<nav>
			<ul>
            <li><a href="Library.htm">
            	<img src="../images/official_logo.png" title="Library" alt="Library" height="30" width="30" class="left"></a></li>
            <li>
            		<a href="Profile.php">
            			<img src="<?php echo $user_image;?>" title="Profile" alt="Profile" height="40" width="40" id="logo2">
            			<label for="username"><?php echo $_SESSION['username'];?></label>
            		</a>
            </li>
            <li><a href="Search.htm" class="right"> Search </a></li>
            <li> | </li>
            <li><a href="Settings.htm">
            	<img src="../images/setting_icon.png" title="Settings" alt="Settings" height="20" width="20"></a></li>
        	</ul>
		</nav>
		</header>
	<div class="container">
			<h1 id="srch_results">Search Results for keyword:" <?php echo "keyword"?> "</h1>

	   
<div class=" shelf_section well well-sm " >
<?php 
	if($numbooks > 0){ ?>
<?php
	   	while($row = mysqli_fetch_array($shelf_result)){ ;?>
          	<a class="bookshelf_book_container" href="Public_book_info.php?id=<?php echo $row["book_id"];?>" >
				<content class="bookshelf_book"></content>
				<label for="book_title" id="book_title"> <?=shorten($row["book_name"]);?> </label>
			</a>
 <?php 	} 
    } ?>

</div>

	 <content id="prev_next">
	 	<a href=" " id="prev" ><< Prev </a> &nbsp|&nbsp
	 	<a href=" " id="next" >Next >> </a>
	 </content>

	</div>	
		<footer>
			<p>A.Y. 2016-2017 Bookshare | &copy;CMSC 128 Lab Sec. 2 |  2016</p>
		</footer>
	</div>
</body>
</html>
