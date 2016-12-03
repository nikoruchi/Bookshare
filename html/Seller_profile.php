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
      $user_name = $row_session['username'];
      $password = $row_session['password'];
      $imagepath = $row_session['account_imagepath'];
      $year_level = $row_session['year_level'];
      $course = $row_session['course'];
      $query1 ="SELECT * FROM account_contacts where account_id='$account_id'";
      $result1 = mysqli_query($dbconn, $query1);
      //$rows1 = mysqli_num_rows($result1); 
      //$row1 = mysqli_fetch_assoc($result1);
      //$contact_number=$row1['contact_number'];
      $query2 ="SELECT * FROM account_emails where account_id='$account_id'";
      $result2 = mysqli_query($dbconn, $query2);
      //$rows2 = mysqli_num_rows($result2); 
      //$row2 = mysqli_fetch_assoc($result2);
      //$email=$row2['email'];

      // if(isset($_POST['Edit'])){ 
      
      // header("Location:edit.php");  
      // }
  
    ?>

<!DOCTYPE html>
<html class="no-js">
<head>
	<meta charset="utf-8">
	<meta name="author" content="CMSC 128 Lab Sec. 2">
	<meta name="description" content="Sell, buy, and trade books with your schoolmates.">
	<meta name="keywords" content="Book, Books, Trade Book, Sell Book, Buy Book">
	<title>Your Profile</title>

  <link rel="shortcut icon" href="../images/official_logo.png">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
  <link rel="stylesheet" type="text/css" href="../css/profile_style.css">
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
            			<img src=src="<?php echo $imagepath ?>" title="Profile" alt="Profile" height="40" width="40" id="logo2">
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
			<a href="Seller_profile.php?seller=<?php echo $account_id?>"><h1 id="bookshelf">Seller - <?php echo $user_name?> </h1></a>

    <div class="profile_header">
      <aside>
        <div>
          <img id="user_pic" src="<?php echo $imagepath ?>" alt="user photo">
        </div>  
        <div id="yrlvl_course">
          <label id="course"><?php echo  $course?></label>
          <label><?php echo  $year_level?></label>
        </div>
      </aside>
      <div id="profile_side">
        <div id="prof_name">
          <label id="accountname"><?php echo  $account_name?></label>
          <label id="username"><?php echo $user_name?></label>
        </div>
        <div id="contact_section">
          <label>Contact Number/s:</label> 
<?php       while($row1 = mysqli_fetch_assoc($result1)){ 
              $contact_number=$row1['contact_number'];?>
              <div id="multi_inputs">
                <content><?php echo $contact_number; ?></content>
              </div>
<?php    } ?>
        </div>
        <div id="contact_section">
          <label>Email/s:</label> 
<?php       while($row1 = mysqli_fetch_assoc($result2)){ 
                $email = $row1['email'];?>
                <div id="multi_inputs">
                    <content><?php echo  $email; ?></content>
                </div>
<?php    } ?>
        </div>
      </div>
    </div>

<div class="activity_section">
  <div class="icon_section">
      <a href="Public_bookshelf.php?seller=<?php echo $account_id?>" id="bookshelf_section">
        <div id="image_bookshelf">
          <img src="../images/bookshelf.png">
        </div>
        <div id="label_bookshelf">
          <img src="../images/label_bookshelf.png">
        </div>
      </a>
  </div>




<div class="notif_section well well-sm">
      <h2>Bookshelf</h2>

    
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
