<?php
	include("connect.php");
	include("search_book.php");
	session_start();?>

<?php

	$seller = $_SESSION['buyer_id'];
	$user_query= "SELECT * from account where account_id='$seller'";
    $user_result=mysqli_query($dbconn, $user_query);
    $row_session = mysqli_fetch_assoc($user_result);
    $user_image = $row_session['account_imagepath'];

    $prompt='';
    $prompt2='';
    $prev_price="";
	$prev_title='';
	$prev_edition="";
	$prev_category="";
	$prev_author="";
	$prev_description="";
	$prev_details="";
	$prev_pages="";
	$prev_quality="";

  
	if(isset($_POST['add'])){
	 	$price=$_POST["price"];
 		$title=addslashes($_POST["title"]);
 		$edition=addslashes($_POST["edition"]);
 		$category = $_POST["category"];
 		$authors=addslashes($_POST["author"]);
 		$description=addslashes($_POST["description"]);
 		$details=addslashes($_POST["details"]);
 		$pages = $_POST["pages"];
 		$quality = $_POST["quality"];
 		$book_path="../uploads/default.jpg";


 		$prev_price=$price;
		$prev_title=$title;
		$prev_edition=$edition;
		$prev_category=$category;
		$prev_author=$authors;
		$prev_description=$description;
		$prev_details=$details;
		$prev_pages=$pages;
		$prev_quality=$quality;

		if(empty($edition)){
			$edition = '';
		}
		if(empty($category)){
			$category = "--";
		}
		if(empty($authors)){
			$authors = "Not Specified";
		}
		if(empty($description)){
			$description="no description added";
		}
		if(empty($details)){
			$details="n/a";
		}
		if(empty($pages)){
			$pages = "0";
		}
		if(empty($quality)){
			$quality = "n/a";
		}

 		if($price=='' || $title==''){
			$prompt="**Title and Price are Required. ";
		}


		if($prompt==''){
	 		$book_add = "INSERT INTO books (account_id, book_name, book_edition, book_price, book_desc, book_imagepath) VALUES('$seller','$title', '$edition','$price','$description', '$book_path')";
	        $add_result= mysqli_query($dbconn, $book_add); 

	        if($add_result){
	        	$book_added="SELECT max(book_id) as book_id from books";
	        	$added_result = mysqli_query($dbconn,$book_added);
	        	$row1=mysqli_fetch_assoc($added_result);
	        	$book_id_val=$row1["book_id"];
	        	
	        	$add_book1="INSERT INTO book_info (book_id,book_subject, book_author, book_details, book_pages, book_quality) VALUES ('$book_id_val','$category','$authors','$details', '$pages', '$quality')";
	        	if(mysqli_query($dbconn, $add_book1)){
	        		header("Location:Edit_book_info.php?id=$book_id_val");
	        	} 
	        } 
	        else {
	        	echo "Book not added.";
	        }
    	}
	}



    if(isset($_POST['cancel'])){  
		header("Location: Bookshelf.php");
	}
?>

<!DOCTYPE html>
<html class="no-js">
<head>
	<meta charset="utf-8">
	<meta name="author" content="CMSC 128 Lab Sec. 2">
	<meta name="description" content="Sell, buy, and trade books with your schoolmates.">
	<meta name="keywords" content="Book, Books, Trade Book, Sell Book, Buy Book">
	<title> Add Book  </title>

	<link rel="shortcut icon" href="../images/official_logo.png">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
  	<link rel="stylesheet" type="text/css" href="../css/component.css" />
  	<script src="../js/jquery.min.js"></script>
  	<link rel="stylesheet" type="text/css" href="../css/normalize.css">
  	<script src="../js/modal.js"></script>
  	<script src="../js/custom-file-input.js"></script>
  	<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>

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
            			<img src="<?php echo $user_image; ?>" title="Profile" alt="Profile" height="40" width="40" id="logo2">
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
		<h1 id="bookshelf">Bookshelf</h1>
	 <div class=" info_section well well-sm" > 

		<?php
			if(empty($prompt)||empty($prompt2)){ ?>
    			<br>
		<?php } 
			else{ ?>
        		<div id="prompt"> 
        			<?php echo $prompt; 
        			echo $prompt2; ?>
        		 </div>
    	<?php } ?>

	  <form  method="post" action = "<?php $_PHP_SELF; ?>" > 
	  <div class="info">
	  	<div id="book_image_container">
	  		<img id="book_pic_edit" src="../images/default.jpg" width="200" height="275" />
	    </div>

		<div class="book_info1">
			<content class="col-xs-4" id='price'>
				<label for='price' id='price'>Price:</label>
				<input type="text" name="price" required="" value="<?= $prev_price; ?>" class="form-control">
			</content>
		</div>
		<div class="book_info1a">
 			<label for="category" id="book_info1a_label">Course Category:</label>
 			<?php 
 				$prev_category;
 				$subject_counter = 0;
 				$subject = array("--", "Accountancy", "Applied Mathematics", "Biology", "Business Administration", "Chemical Engineering", "Chemistry", "Communication And Media Studies", "Community Development", "Computer Science", "Economics", "Fisheries", "Food Technology", "History", "Literature", "Management", "Political Science", "Psychology", "Public Health", "Sociology", "Statistics");
 			?>

				<select name="category" id="category" class="form-control">		
				<?php for($subject_counter=0; $subject_counter<21; $subject_counter++){
					if($prev_category==$subject[$subject_counter]){	?>
			   		<option selected="" value="<?php echo $subject[$subject_counter]; ?>"> <?php echo $subject[$subject_counter]; ?> </option>
			   		<?php } else{?>
			   		<option value="<?php echo $subject[$subject_counter]; ?>"> <?php echo $subject[$subject_counter]; ?> </option>
			   		<?php }}?>
			   	
				</select>
 		</div>

		<div class="book_info2e">
			<content class="col-xs-10">
				<label for='title' id="info_label">Title: </label>
				<input required="" type="text" name="title" class="form-control" placeholder="Title of the Book" value="<?= $prev_title; ?>">
			</content>
			<content class="col-xs-2">
				<label for='edition' id="info_label">Edition: </label>
				<input type="text" name="edition" class="form-control" placeholder="1st, 2nd, etc." value="<?= $prev_edition?>">
			</content>
			<content class=" extra_details col-xs-2">
				<label id="info_label" for='quality'>Quality: </label>
				<input type="text" name="quality" class="form-control" placeholder="0-100%" value="<?= $prev_quality?>">
			</content>
			<content class=" extra_details col-xs-4">
				<label  id="info_label" for='pages'>Pages: </label>
				<input type="text" name="pages" class="form-control" placeholder="# of pages" value="<?= $prev_pages?>">
			</content>
			<content class="col-xs-10">
				<label for='author' id="info_label" >Author/s: </label>
				<input type="text" name="author" class="form-control" placeholder="Author/s of the Book" value="<?= $prev_author?>">
				<label for='description' id="info_label">Description: </label>
				<textarea name="description" size="100" class="form-control" id="description" placeholder="What is this book about?" value="<?= $prev_description?>"></textarea>
				<label for='details' id="info_label">Details: </label>
				<textarea name="details" value=" " size="100" class="form-control" id="details" placeholder="Does the book have any specifc features? (e.g: author's signature, plastic cover, etc)" value="<?= $prev_details?>"></textarea>
			</content>
		</div>

	  </div>
	  <div class="edit-btn-container">
	  	
	  		<input type="submit" name="add" value="Add Book" class="btn btn-default">
	  		<input type="submit" name="cancel" value="Cancel" class="btn btn-danger">
	  </div>

	  </form>
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
  var id = <?php echo json_encode($seller);?>;  
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