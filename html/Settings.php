<?php
	include("connect.php");
	include("search_book.php");
  session_start();
	?>
<?php
    
      
      $account_id = $_SESSION['buyer_id'];
      $user_name = $_SESSION['username'];
      
      $user_query= "SELECT * from account where account_id='$account_id'";
      $user_result=mysqli_query($dbconn, $user_query);
      $row_session = mysqli_fetch_assoc($user_result);
      $account_name = $row_session['account_name'];
      $password = $row_session['password'];
      $year_level = $row_session['year_level'];
      $user_image = $row_session['account_imagepath'];
      $course = $row_session['course'];
      $query1 ="SELECT * FROM account_contacts where account_id='$account_id'";
      $result1 = mysqli_query($dbconn, $query1);
      $query2 ="SELECT * FROM account_emails where account_id='$account_id'";
      $result2 = mysqli_query($dbconn, $query2);
  
    ?>

<?php 

    if(isset($_POST['save_pic'])){
      $target_dir = "../uploads/";
      $target_file = $target_dir . basename($_FILES["pic-upload"]["name"]);
      $uploadOk = 1;
      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

      // Check if image file is a actual image or fake image

          $check = getimagesize($_FILES["pic-upload"]["tmp_name"]);
          if($check == false) {
              msg("File is not an image.");
              $uploadOk = 0;
          }


      // Check if file already exists
      if (file_exists($target_file)) {
          msg("Sorry, file already exists.");
          $uploadOk = 0;
      }

      // Check file size
      if ($_FILES["pic-upload"]["size"] > 500000) {
          msg("Sorry, your file is too large.");
          $uploadOk = 0;
      }

      // Allow certain file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
          msg("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
          $uploadOk = 0;
      }

      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
          msg("Sorry, your file was not uploaded.");
      // if everything is ok, try to upload file
      } else {
          if (move_uploaded_file($_FILES["pic-upload"]["tmp_name"], $target_file)) {
             // echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

              $sql = "UPDATE account SET account_imagepath='$target_file' WHERE account_id='$account_id'";
              $add_image= mysqli_query($dbconn, $sql); 
              if($add_image){
                  header("Refresh:0");
              }
          } else {
              msg("Sorry, there was an error uploading your file.");
          }
      }
    }

    function msg($mess){?>    
    <p><?=$mess;?></p>
    <?php }

?>



<!DOCTYPE html>
<html class="no-js">
<head>
	<meta charset="utf-8">
	<meta name="author" content="CMSC 128 Lab Sec. 2">
	<meta name="description" content="Sell, buy, and trade books with your schoolmates.">
	<meta name="keywords" content="Book, Books, Trade Book, Sell Book, Buy Book">
	<title> Account Settings </title>

  <link rel="shortcut icon" href="../images/official_logo.png">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
  <link rel="stylesheet" type="text/css" href="../css/stylesettings.css">
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
			<a href="Settings.php"><h1 id="bookshelf">Account Settings</h1></a>
	  <div class="set_section well well-sm">

      <div class="dropdown_menu">
        <div class="edit_container">
            <img src="../images/edit_icon.png" title="Edit" alt="Edit" height="25" width="65" id="edit_icon" onclick="edit_menu()" class=" edit_btn">
        </div>
        <div id="edit_dropdown" class="edit_dropdown_content">
            <a  data-toggle="modal" data-target="#myModal5">Change Photo</a>
            <a  data-toggle="modal" data-target="#myModal5A">Change Password</a>
            <a href="edit.php">Edit Account</a>
        </div>
     </div>
       
        <form action="edit.php" method="post" >  
          <aside>
            <div class="upload_center">
                <img id="user_pic" src="<?php echo $user_image;?>"  alt="user photo">
            </div>  
          </aside>

            <div class="data_section">
            <h2>PERSONAL DATA:</h2>
              <div class="data">
                <span id="perso">
                  <label id="name">Name:</label>
                  <content><?php echo $account_name; ?></content>
                </span id="perso">
                <span id="perso">
                  <label id="user">Username:</label>
                  <content><?php echo $user_name; ?></content>
                </span>
                <span id="perso">
                  <label id="password">Password:</label>
                  <content></content>
                </span>
                <span id="perso">  
                  <label id="year">Year:</label>
                  <content><?php echo  $year_level; ?></content>
                </span>
                <span id="perso">  
                  <label id="year">Course:</label>
                  <content><?php echo  $course; ?></content>
                </span>
              </div>
            </div>
             <div class="data_section">
             <h2>CONTACT INFORMATION</h2>
             <div class="data">
              <span id="contact">
                <label id="number">Contact Number/s:</label> 
       <?php        while($row1 = mysqli_fetch_assoc($result1)){ 
                        $contact_number=$row1['contact_number'];?>
                        <div id="multi_inputs">
                            <content><?php echo $contact_number; ?></content>
                        </div>
       <?php    } ?>
                </span>
                <span id="contact">
                <label id="email">Email/s:</label> 
       <?php        while($row1 = mysqli_fetch_assoc($result2)){ 
                        $email = $row1['email'];?>
                        <div id="multi_inputs">
                            <content><?php echo  $email; ?></content>
                        </div>
       <?php    } ?>
                </span>
             </div>
             </div>
      </form>
    </div>

<!-- UPDATE PHOTO MODAL -->
<div class="modal fade" id="myModal5" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
      <form method="post" action="<?php $_PHP_SELF; ?>" enctype="multipart/form-data">
        <div class="modal-header">
          <h4 class="modal-title">Change Your Profile Picture</h4>
        </div>
        <div class="modal-body">
          <div class="edit_user_pic_section">
            <img id="user_pic_edit" src="<?php echo $user_image;?>"  alt="user photo" >
          </div>
          <label class="fileUpload btn btn-success">    
            <span>Upload</span> 
            <input type="file" name="pic-upload" id="pic-upload" class="upload" />
          </label>
        </div>
        <div class="modal-footer">
        <input type="submit" value="UPDATE" name="save_pic" class="btn btn-default">
        <input type="submit" value="CANCEL" class="btn btn-danger">
        </div>
        </form>
      </div>
    </div>
  </div>

<!-- CHANGE PASSWORD MODAL -->
<div class="modal fade" id="myModal5A" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
      <form method="post" action="<?php $_PHP_SELF; ?>" enctype="multipart/form-data">
        <div class="modal-header">
          <h4 class="modal-title">Change Your Password</h4>
        </div>
        <div class="modal-body">
          <content class="col-xs-set password">
              <label id="password">Old Password:</label>
              <input class="form-control-set" type="password" name="password" value="<?php echo $password; ?>"> 
              <label id="password">New Password:</label>
              <input class="form-control-set" type="password" name="new-password" value="<?php echo $password; ?>"> 
              <label id="re-password">Re-type Password:</label>
              <input class="form-control-set" type="password" name="re-password"> 
          </content>
        </div>
        <div class="modal-footer">
        <input type="submit" value="UPDATE" name="save_pic" class="btn btn-default">
        <input type="submit" value="CANCEL" class="btn btn-danger">
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