<?php
	include("connect.php");
	include("search_book.php");
  session_start();
	?>

<?php

    $id = $_SESSION['buyer_id'];
    $user_query= "SELECT * from account where account_id='$id'";
    $user_result=mysqli_query($dbconn, $user_query);
    $row_session = mysqli_fetch_assoc($user_result);
    $user_image = $row_session['account_imagepath'];

    
      $account_id = $_GET['seller'];
      //$account_id = 1;
      $user_query= "SELECT * from account where account_id='$account_id'";
      $user_result=mysqli_query($dbconn, $user_query);
      $row_session = mysqli_fetch_assoc($user_result);
      $account_name = $row_session['account_name'];
    

    $resultperpage = 18;
    if(isset($_GET['page'])){
      $page=$_GET['page'];
    }else{ 
      $page=1;
    }
    $start_from = ($page-1)*$resultperpage;

  $bookname_shelf = "SELECT * from books as B join account as A on B.account_id=A.account_id WHERE B.account_id='$account_id' order by book_id asc limit $start_from,".$resultperpage;
  $shelf_result=mysqli_query($dbconn, $bookname_shelf);
  $numbooks=mysqli_num_rows($shelf_result);
  $totalpages = ceil($numbooks['$numbooks']);
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
            			<img src="<?php echo $user_image?>" title="Profile" alt="Profile" height="40" width="40" id="logo2">
            			<label for="username"><?php echo $_SESSION['username']?></label>
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
			<a href="Public_bookshelf.php?seller=<?php echo $account_id;?>"><h1 id="bookshelf">Bookshelf- <?php echo $account_name ?></h1></a>

	   
<div class=" shelf_section well well-sm " >
<?php 
	if($numbooks > 0){ ?>
<?php
	   	while($row = mysqli_fetch_array($shelf_result)){ ;?>
          	<a class="bookshelf_book_container" href="Public_book_info.php?id=<?php echo $row["book_id"];?>" >
				<content class="bookshelf_book">
          <img height="220" width="150" class="" alt="<?=$row["book_name"];?>" title="<?=$row["book_name"];?>" src="<?php echo $row['book_imagepath']; ?>">
        <label>Php<?=$row["book_price"];?><br><?=$row["book_name"];?></label>
        </content>
			</a>
 <?php 	} 
    } ?>

</div>

   <content id="prev_next">

<?php
  if($page=='1'){?>
    <a href=" " id="prev" ><< Prev </a> &nbsp;|&nbsp;
    <a href="Public_bookshelf.php?page=<?php echo $page+1;?>&amp;seller=<?php echo $account_id;?>" name="page">Next >></a>
<?php
  }else{?>
    <a href="Public_bookshelf.php?page=<?php echo $page-1?>&amp;seller=<?php echo $account_id;?>" name="page"><< Prev</a>  &nbsp;|&nbsp;
    <a href="Public_bookshelf.php?page=<?php echo $page+1?>&amp;seller=<?php echo $account_id;?>" id="next" name="page">Next</a>
 <?php }
?>
   </content>

<!-- DON'T -->
  </div> 
		<footer>
			<p>A.Y. 2016-2017 Bookshare | &copy;CMSC 128 Lab Sec. 2 |  2016</p>
		</footer>
	</div>
</body>
</html>
