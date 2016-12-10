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

  
	if(isset($_POST['add'])){
	 	$price=$_POST["price"];
 		$title=addslashes($_POST["title"]);
 		$edition=addslashes($_POST["edition"]);
 		$category = $_POST["category"];
 		$authors=addslashes($_POST["author"]);
 		$description=addslashes($_POST["description"]);
 		$details=addslashes($_POST["details"]);
 		$book_path="../uploads/default.jpg";

 		if($price=='' || $title==''){
			$prompt="**Title and Price are Required. ";
		}


		if($prompt==''){
	 		$book_add = "INSERT INTO books (account_id, book_name, book_edition, book_price, book_desc, book_imagepath) VALUES('$seller','$title', '$edition','$price','$description', '$book_path')";
	        $add_result= mysqli_query($dbconn, $book_add); 

	        if($add_result){
	        	$book_added="SELECT * FROM books WHERE book_name ='$title' AND account_id='$seller' AND book_edition='$edition'";
	        	$added_result = mysqli_query($dbconn,$book_added);
	        	while($row1=mysqli_fetch_assoc($added_result)){
	        		$book_id_val=$row1["book_id"];
	        	}
	        	$add_book1="INSERT INTO book_info (book_id, book_subject, book_author, book_details) VALUES ('$book_id_val','$category','$authors','$details')";
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
				<input type="text" name="price" value=" " class="form-control">
			</content>
		</div>
		<div class="book_info1a">
 			<label for="category" id="book_info1a_label">Course Category:</label>
 			<select name="category" id="category" class="form-control">			
			   	<option value=" "> -- </option>
			   	<option value="Accountancy"> Accountancy </option>
			   	<option value="Applied Mathematics"> Applied Mathematics </option>			   	
			   	<option value="Biology"> Biology </option>
			   	<option value="Business Administration"> Business Administration </option>
			   	<option value="Chemical Engineering"> Chemical Engineering </option>
			   	<option value="Chemistry"> Chemistry </option>
			   	<option value="Communication And Media Studies"> Communication and Media Studies </option>
			   	<option value="Community Development"> Community Development </option>
			   	<option value="Computer Science"> Computer Science </option>
			   	<option value="Economics"> Economics </option>
			   	<option value="Fisheries"> Fisheries </option>
			   	<option value="Food Technology"> Food Technology </option>
			   	<option value="History"> History </option>
			   	<option value="Literature"> Literature </option>
			   	<option value="Management"> Management </option>
			   	<option value="Political Science"> Political Science </option>
			   	<option value="Psychology"> Psychology </option>
			   	<option value="Public Health"> Public Health </option>
			   	<option value="Sociology"> Sociology </option>
			   	<option value="Statistics"> Statistics </option>
			</select>
 		</div>
		<div class="book_info2e">
			<content class="col-xs-10">
				<label for='title' id="info_label">Title: </label>
				<input type="text" name="title" class="form-control" placeholder="Title of the Book" >
			</content>
			<content class="col-xs-2">
				<label for='edition' id="info_label">Edition: </label>
				<input type="text" name="edition" class="form-control" placeholder="1st, 2nd, etc.">
			</content>
			<content class=" extra_details col-xs-2">
				<label id="info_label" for='quality'>Quality: </label>
				<input type="text" name="quality" class="form-control" placeholder="0-100%">
			</content>
			<content class=" extra_details col-xs-4">
				<label  id="info_label" for='quality'>Pages: </label>
				<input type="text" name="price" class="form-control" placeholder="# of pages">
			</content>
			<content class="col-xs-10">
				<label for='author' id="info_label" >Author/s: </label>
				<input type="text" name="author" class="form-control" placeholder="Author/s of the Book">
				<label for='description' id="info_label">Description: </label>
				<textarea name="description" size="100" class="form-control" id="description" placeholder="What is this book about?"></textarea>
				<label for='details' id="info_label">Details: </label>
				<textarea name="details" value=" " size="100" class="form-control" id="details" placeholder="Does the book have any specifc features? (e.g: author's signature, plastic cover, etc)"></textarea>
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
