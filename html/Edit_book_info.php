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

	$book_id_val=$_GET["id"];  	
  	if(isset($book_id_val)){
  		$book_info = "SELECT * from book_info BI, books B where B.book_id=BI.book_id and BI.book_id=$book_id_val";
  		$info_result=mysqli_query($dbconn, $book_info);
  		if ($info_result){
  			while ($row=mysqli_fetch_assoc($info_result)){ 
 				$Price=$row["book_price"];
 				$Quality=$row["book_quality"];
 				$Pages=$row["book_pages"];
 				$Title=$row["book_name"];
 				$Edition=$row["book_edition"];
 				$Authors=$row["book_author"];
 				$Description=$row["book_desc"];
 				$Details=$row["book_details"];
 				$Category=$row["book_subject"];
 				$book_image=$row["book_imagepath"];
 			}
  		} 
  	}
?>

<?php
	if(isset($_POST['update'])){
		$price=addslashes($_POST["price"]);
	 	$title=addslashes($_POST["title"]);
	 	$edition=addslashes($_POST["edition"]);
	 	$authors=addslashes($_POST["author"]);
	 	$description=addslashes($_POST["description"]);
	 	$details=addslashes($_POST["details"]);
	 	$book_id=$_GET["id"];
	 	$category = $_POST["category"];
	 	$prompt='';

	 	if($price=='' || $title==''){
			$prompt="**Title and Price are Required. ";
		}

		if($category==''){
			$category=$Category;
		}
		
	  	if ($prompt=='') {
			$info_update = "UPDATE book_info BI, books B SET book_price= '$price', book_name= '$title', book_author= '$authors', book_desc= '$description', book_details= '$details', book_edition='$edition', book_subject='$category' where B.book_id=BI.book_id and BI.book_id=$book_id";
			$update_result=mysqli_query( $dbconn, $info_update);

	    	if($update_result){
	    		header("Location:Book_info.php?id=$book_id");?>
	    		<h1>UPDATED</h1>
	    		<?php mysqli_close($dbconn);
	    	}
	    	else{
	    		echo "ERR";
	    	}
		}
	}

	if(isset($_POST['cancel'])){  
		$book_id=$_GET["id"];
		header("Location: Book_info.php?id=$book_id");
	}


	if(isset($_POST['save_pic'])){

    	if(empty(basename($_FILES["pic-upload"]["name"]))){
  			$prompt2= "Please Select Image File.";
  		} else {
  			$target_dir = "../uploads/";
			$target_file = $target_dir . basename($_FILES["pic-upload"]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
  		

			$check = getimagesize($_FILES["pic-upload"]["tmp_name"]);
			if($check == false) {
			    echo "File is not an image.";
			    $uploadOk = 0;
			}
			

			// Check if file already exists
			if (file_exists($target_file)) {
			    echo "Sorry, file already exists.";
			    $uploadOk = 0;
			}

			// Check file size
			if ($_FILES["pic-upload"]["size"] > 500000) {
			    echo "Sorry, your file is too large.";
			    $uploadOk = 0;
			}

			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			    $uploadOk = 0;
			}

			if(move_uploaded_file($_FILES["pic-upload"]["tmp_name"], $target_file)){
	        	$sql = "UPDATE books SET book_imagepath='$target_file' WHERE book_id='$book_id_val'";
		        $add_image = mysqli_query($dbconn, $sql); 
		       	if($add_image){
		            header("refresh:0");
		        }	        			
	        }
		}
    }

?>


<!DOCTYPE html>
<html class="no-js">
<head>
	<meta charset="utf-8">
	<meta name="author" content="CMSC 128 Lab Sec. 2">
	<meta name="description" content="Sell, buy, and trade books with your schoolmates.">
	<meta name="keywords" content="Book, Books, Trade Book, Sell Book, Buy Book">
	<title> Edit Book Info </title>

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
	  		<img id="book_pic_edit" src="<?php echo $book_image;?>" width="200" height="275" />
	    
	    <div class="upload_image_container">	
	  		<img src="../images/upload_image.png" title="Upload Image" alt="Upload Image" width="200" height="275" class="upload_image_icon" data-toggle="modal" data-target="#myModal9">
	  	</div>

	  	</div>

		<div class="book_info1">
			<content class="col-xs-4" id='price'>
				<label for='price' id='price'>Price:</label>
				<input type="text" name="price" class="form-control" value="<?php echo $Price ?>">
			</content>
		</div>
		<div class="book_info1a">
 			<label for="category" id="book_info1a_label"> Course Category: </label>
				<select name="category" id="category" class="form-control">			
			   	<option value=""> -- </option>
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
				<input type="text" name="title" class="form-control" placeholder="Title of the Book" value="<?php echo $Title ?>">
			</content>
			<content class="col-xs-2">
				<label for='edition' id="info_label">Edition: </label>
				<input type="text" name="edition" class="form-control" placeholder="1st, 2nd, etc." value="<?php echo $Edition ?>">
			</content>
			<content class=" extra_details col-xs-2">
				<label id="info_label" for='quality'>Quality: </label>
				<input type="text" name="quality" class="form-control" value="<?php echo $Quality ?>" placeholder="0-100%">
			</content>
			<content class=" extra_details col-xs-4">
				<label  id="info_label" for='quality'>Pages: </label>
				<input type="text" name="price" class="form-control" value="<?php echo $Pages ?>" placeholder="# of pages">
			</content>
			<content class="col-xs-10">
				<label for='author' id="info_label" >Author/s: </label>
				<input type="text" name="author" class="form-control" placeholder="Author/s of the Book" value="<?php echo $Authors ?>">
				<label for='description' id="info_label">Description: </label>
				<textarea name="description" size="100" class="form-control" id="description" placeholder="What is this book about?"><?php echo $Description ?></textarea>
				<label for='details' id="info_label">Details: </label>
				<textarea name="details" value=" " size="100" class="form-control" id="details" placeholder="Does the book have any specifc features? (e.g: author's signature, plastic cover, etc)"><?php echo $Details ?></textarea>
			</content>
		</div>

	  </div>
	  <div class="edit-btn-container">
	  	<input type="submit" name="update" value="Update Book " class="btn btn-default">
	  	<input type="submit" name="cancel" value="Cancel" class="btn btn-danger">
	  </div>
	</form>
	</div>	
	</div>

<!-- UPDATE BOOK PHOTO MODAL -->
<div class="modal fade" id="myModal9" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
      <form method="post" action="<?php $_PHP_SELF; ?>" enctype="multipart/form-data">
        <div class="modal-header">
          <h4 class="modal-title">Change Your Book's Photo</h4>
        </div>
        <div class="modal-body">
          <div class="edit_user_pic_sectiona">
            <img id="book_pic" src="<?php echo $book_image;?>" width="200" height="275" alt="user photo" >
          </div>
          <label class="fileUpload btn btn-success">    
            <span>Upload</span> 
            <input type="file" name="pic-upload" id="pic-upload" class="upload" />
          </label>
        <div class="modal-footer">
        		<input type="submit" value="UPDATE" name="save_pic" class="btn btn-default">
        		<input type="submit" value="CANCEL" class="btn btn-danger">
      		</form>
        </div>
      </div>
    </div>
  </div>

  </div>
		<footer>
			<p>A.Y. 2016-2017 Bookshare | &copy;CMSC 128 Lab Sec. 2 |  2016</p>
		</footer>
	</div>
</body>
</html>

