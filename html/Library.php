<?php 
	include("connect.php");
	include("search_book.php");
	session_start();

	$buyer_id = $_SESSION['buyer_id'];
	$user_query= "SELECT * from account where account_id='$buyer_id'";
    $user_result=mysqli_query($dbconn, $user_query);
    $row_session = mysqli_fetch_assoc($user_result);
    $user_image = $row_session['account_imagepath'];
    $resultperpage = 12;
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="CMSC 128 Lab Sec. 2">
	<meta name="description" content="Sell, buy, and trade books with your schoolmates.">
	<meta name="keywords" content="Book, Books, Trade Book, Sell Book, Buy Book">
	<title> Library </title>

	<link rel="shortcut icon" href="../images/official_logo.png">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/normalize.css">
	<link rel="stylesheet" type="text/css" href="../css/library_style.css">
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
            			<img src="<?php echo $user_image?>" title="Profile" alt="Profile" height="40" width="40" id="logo2">
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
	

	<aside class="categories well well-sm">
			<table>
			<th>Books by Courses:</th>
				<tr><td><a href="Library.php?ID=Accountancy">Accountancy</a></td></tr>
				<tr><td><a href="Library.php?ID=Applied Mathematics">Applied Mathematics</a></td></tr>
				<tr><td><a href="Library.php?ID=Biology">Biology</a></td></tr>
				<tr><td><a href="Library.php?ID=Business Administration">Business Administration</a></td></tr>
				<tr><td><a href="Library.php?ID=Chemical Engineering">Chemical Engineering</a></td></tr>
				<tr><td><a href="Library.php?ID=Chemistry">Chemistry</a></td></tr>
				<tr><td><a href="Library.php?ID=Communication and Media Studies">Communication and Media Studies</a></td></tr>
				<tr><td><a href="Library.php?ID=Community Development">Community Development</a></td></tr>
				<tr><td><a href="Library.php?ID=Computer Science">Computer Science</a></td></tr>
				<tr><td><a href="Library.php?ID=Economics">Economics</a></td></tr>
				<tr><td><a href="Library.php?ID=Fisheries">Fisheries</a></td></tr>
				<tr><td><a href="Library.php?ID=Food Technology">Food Technology</a></td></tr>
				<tr><td><a href="Library.php?ID=History">History</a></td></tr>
				<tr><td><a href="Library.php?ID=Literature">Literature</a></td></tr>
				<tr><td><a href="Library.php?ID=Management">Management</a></td></tr>
				<tr><td><a href="Library.php?ID=Political Science">Political Science</a></td></tr>
				<tr><td><a href="Library.php?ID=Psychology">Psychology</a></td></tr>
				<tr><td><a href="Library.php?ID=Public Health">Public Health</a></td></tr>
				<tr><td><a href="Library.php?ID=Sociology">Sociology</a></td></tr>
				<tr><td><a href="Library.php?ID=Statistics">Statistics</a></td></tr>				
			</table>
	</aside>
	<div class="library_shelf">
	 <div class="course_cat">

	  <?php 
	  		if(isset($_GET['page'])){
    			$page=$_GET['page'];
  			}else{
   				$page=0;
  			}

	 		if (isset($_GET['ID'])) {
				$course=$_GET['ID'];
			} else {
				$course="Bookshare Library";
			}
	
	   ?>
	 		<h2 id="ID_label"><?php echo $course ?></h2>
	 		
	 </div>

	 <div class=" library_section well well-sm " >
		<?php
		if(($course!="Bookshare Library")){  
			$start_from = ($page)*$resultperpage;
			$query = "SELECT * FROM book_info WHERE book_subject LIKE '%$course%' order by book_id asc limit $start_from,".$resultperpage;
			$result = mysqli_query($dbconn,$query);

			$sql01 = "SELECT * FROM book_info WHERE book_subject LIKE '%course%' order by book_id asc";
			$retval = mysqli_query($dbconn, $sql01);
			$totalbooks = mysqli_num_rows($retval);
			$totalpages = ceil($totalbooks/$resultperpage);

			if((mysqli_num_rows($result))>0){ 
				while(list($info_id,$book_id,$book_subject, $book_pages,$book_quality,$book_author,$book_details)=mysqli_fetch_row($result)){
					$que = "SELECT * FROM books WHERE books.book_id = '$book_id' AND books.book_id NOT IN (SELECT cart.book_id FROM cart)";
					$res = mysqli_query($dbconn,$que);

					$value = mysqli_num_rows($res);

					if(mysqli_num_rows($res)>0){
						while(list($book_id,$account_id,$book_name,$book_edition,$book_price,$book_desc,$book_imagepath)=mysqli_fetch_row($res)){?>
							<a class="bookshelf_book_container" href="<?php if($account_id==$buyer_id){echo "Book_info.php?id=".$book_id;}else{ echo "Public_book_info.php?id=".$book_id;}?>" >
								<content class="bookshelf_book">
									<img height="225" width="150" class="" alt="<?=$book_name;?>" title="<?=$book_name?>" src="<?php echo $book_imagepath; ?>">
									<label>Php<?=$book_price;?></label>
								</content>
							</a>
	<?php 				}
					}	
				} 
			}

		} else {

			$start_from = ($page)*$resultperpage;
		
			$query="SELECT * FROM books WHERE books.book_id NOT IN (SELECT cart.book_id FROM cart) order by book_id asc limit $start_from,".$resultperpage; 
			$result = mysqli_query($dbconn,$query);
			$numresult = mysqli_num_rows($result);

			$sql = "SELECT * FROM books WHERE books.book_id NOT IN (SELECT cart.book_id FROM cart) order by book_id asc";
    		$retval = mysqli_query($dbconn, $sql);
    		$totalbooks = mysqli_num_rows($retval);
    		$totalpages = ceil($totalbooks/$resultperpage);

			if(mysqli_num_rows($result)>0) { 
				while(list($book_id,$account_id,$book_name,$book_edition,$book_price,$book_desc,$book_imagepath)=mysqli_fetch_row($result)){ ?>
					<a class="bookshelf_book_container" href="<?php if($account_id==$buyer_id){echo "Book_info.php?id=".$book_id;}else{ echo "Public_book_info.php?id=".$book_id;}?>">
						<content class="bookshelf_book">
							<img height="225" width="150" class="" alt="<?=$book_name;?>" title="<?=$book_name?>" src="<?php echo $book_imagepath; ?>">
							<label>Php<?=$book_price;?></label>
						</content>
					</a>
	<?php 		} 
			} else { ?>
				<p>Record table is empty</p>
	<?php 	}
		}
		mysqli_close($dbconn);
	?>
</div>
  <content id="lib_prev_next">
  	<?php if($page=='0' and $totalpages!='0'){ ?>
		<a href="Library.php?page=<?php echo $page+1?>&amp;ID=<?php echo $course?>" id="next" >Next >> </a>
	<?php }else if($page==$totalpages-1 and $totalpages!='0'){ ?>
	 	<a href="Library.php?page=<?php echo $page-1?>&amp;ID=<?php echo $course?>" id="prev" ><< Prev </a>
	<?php }else if($totalpages=='0'){ ?>
		<p></p>
	<?php }else{ ?>
	 	<a href="Library.php?page=<?php echo $page-1?>" name="page"><< Prev</a>  &nbsp;|&nbsp;
	    <a href="Library.php?page=<?php echo $page+1?>" id="next" name="page">Next >></a>
	 <?php } ?>
	</content>
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
  var id = <?php echo json_encode($buyer_id);?> ; 
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