
<?php
	include("connect.php");
	include("search_book.php");
	session_start();

	
	?>

<?php

  	$buyer_id = $_SESSION['buyer_id'];
	$user_query= "SELECT * from account where account_id='$buyer_id'";
    $user_result=mysqli_query($dbconn, $user_query);
    $row_session = mysqli_fetch_assoc($user_result);
    $user_image = $row_session['account_imagepath'];

  $book_id_val=$_GET["id"];
  $bookname_info="SELECT * from book_info BI, books B where B.book_id=BI.book_id and BI.book_id='$book_id_val'";
  $info_result=mysqli_query($dbconn, $bookname_info);
  $num_info=mysqli_num_rows($info_result);
  if($info_result){
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
?>

<?php
	if(isset($_POST["delete"])){
		$book_id_val=$_GET["id"];
		$book_delete="DELETE FROM book_info WHERE  book_id='$book_id_val' ";
		$del_result=mysqli_query($dbconn, $book_delete);

		if($del_result){ 
			$book_delete="DELETE FROM books WHERE  book_id='$book_id_val'";
			$del_result=mysqli_query($dbconn, $book_delete);

			if($del_result){ 
				header("Location: Bookshelf.php"); 
				mysqli_close($dbconn);
			}
		}
	}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="CMSC 128 Lab Sec. 2">
	<meta name="description" content="Sell, buy, and trade books with your schoolmates.">
	<meta name="keywords" content="Book, Books, Trade Book, Sell Book, Buy Book">
	<title> Book Info </title>

	<link rel="shortcut icon" href="../images/official_logo.png">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
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
		<a href="Bookshelf.php"><h1 id="bookshelf">Bookshelf</h1></a>
	<div class=" info_section well well-sm" > 
	 <div class="dropdown_menu">
	 	<div class="edit_container">
			<img src="../images/edit_icon.png" title="Edit" alt="Edit" height="25" width="65" id="edit_icon" onclick="edit_menu()" class=" edit_btn">
	 	</div>
		<div id="edit_dropdown" class="edit_dropdown_content">
			<a href="Edit_book_info.php ?id=<?php echo $book_id_val;?>"> Edit Content</a>
			<a name="delete" data-toggle="modal" data-target="#myModal4"> Delete Book</a>
		</div>
	 </div>
	

	 <div class="info">
		<div class="book_image_container">
			<img id="book_pic" src="<?php echo $book_image?>" width="200" height="275" />
		</div>
		<div class="book_info1" id="book_info1_label">
			<label for='price' class="info1_items">
				Php <?php echo $Price ?>
			</label>
		</div>
		<div class="book_info1a">
 			<label for="category" id="book_info1a_label"> Course Category: </label>
			<label for='category' class="info1_items"><?php echo $Category ?></label>
			<content id="extra_details">
				<label id="book_info1a_label" for='quality'>Quality: </label>
				<p><?php echo $Quality ?></p>
			</content>
			<content id="extra_details">
				<label id="book_info1a_label" for='pages'>No. of Pages: </label>
				<label><?php echo $Pages ?></label> 
			</content>
		</div>
		<div id="book_info2">
			<label for='title' id="info_label_title"> 
				<h2> <?php echo $Title ?> </h2>
			</label>
			<content class="info_container" id="info_label_title"> 
				<label> <?php 
					if ($Edition==''){$Edition="Unknown";} 
					echo $Edition; ?> Edition
				</label>
			</content>
			<label for='author' id="info_label">Author/s: </label>
			<content class="info_container"> <?php echo $Authors ?> </content>
			<label for='description' id="info_label">Description: </label>
			<content class="info_container"> <?php echo $Description ?> </content>
			<label for='details' id="info_label">Details: </label>
			<content class="info_container"> <?php echo $Details ?> </content>
		</div>
	 </div>

	</div>	
	</div>


<!-- UPDATE EMAIL MODAL -->
  <div class="modal fade" id="myModal4" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
      <form method="post" action="<?php $_PHP_SELF; ?>" >
        <div class="modal-header">
          <h4 class="modal-title">DELETE A BOOK</h4>
        </div>
        <div class="modal-body">
			Once "<?php echo $Title ?>" is deleted, it can't be restored. Proceed?
        </div>
        <div class="modal-footer">
            <form method="post" action="<?php $_PHP_SELF; ?>" >
				<input type="submit" value="DELETE" name="delete" class="btn btn-success">
				<input type="submit" value="CANCEL" class="btn btn-danger">
			</form>
        </div>
        </form>
      </div>
    </div>
  </div>


		<footer>
			<p>A.Y. 2016-2017 Bookshare | &copy;CMSC 128 Lab Sec. 2 |  2016</p>
		</footer>
	</div>
</body>
</html>


<!-- JAVASCRIPT FOR EDIT DROPDOWN MENU -->
<script type="text/javascript">
function edit_menu() {
    document.getElementById("edit_dropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.edit_btn')) {

    var dropdowns = document.getElementsByClassName("edit_dropdown_content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>
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