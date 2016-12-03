	<?php
		include("connect.php");
  		session_start();
		
  		$account_id = $_SESSION['buyer_id'];
      	$user_query= "SELECT * from account where account_id='$account_id'";
      	$user_result=mysqli_query($dbconn, $user_query);
     	$row_session = mysqli_fetch_assoc($user_result);
      	$user_image = $row_session['account_imagepath'];

		if(isset($_GET["ID"])){        		
			$get_id = $_GET["ID"];   	
			$query1 = "SELECT * FROM account_contacts where contact_id='$get_id'"; 
			$result1 = mysqli_query($dbconn, $query1);
			while(list($contact_id,$account_id,$contact_number)=mysqli_fetch_row($result1)){
				$contactold = $contact_number;
			}
		}
	
		if(isset($_POST['update'])){ 
			$get_id = $_GET["ID"];
			$contactz = $_POST['contactnum'];			
			$insert1 = "UPDATE account_contacts SET contact_number='$contactz' WHERE contact_id='$get_id'";
			$insertresult1 = mysqli_query($dbconn, $insert1);			
			if($insertresult1){
				header("Location:edit.php");
			}

		}
		if(isset($_POST['cancel'])){
			header("Location:edit.php");
		}

	?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="CMSC 128 Lab Sec. 2">
	<meta name="description" content="Sell, buy, and trade books with your schoolmates.">
	<meta name="keywords" content="Book, Books, Trade Book, Sell Book, Buy Book">
	<title> Edit Account Settings </title>

    <link rel="shortcut icon" href="../images/official_logo.png">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/style_editsettings.css">
    <link rel="stylesheet" type="text/css" href="../css/stylesettings.css">
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
            	<span class="col-xs-set">            	
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
	   <a href="Settings.php"><h1 id="bookshelf">Account Settings</h1></a>
      <div class="edit_set_section well well-sm " >
            <div class="edit_data2">
              <h2 class="sections">UPDATE '<?php echo $contactold?>' :</h2>
            	<form action="updatecontact.php?ID=<?php echo $get_id;?>" method="POST">
            		<content >
                	<label id="number">Contact Number:</label> 
                	<input class="form-control-set" type="text" name="contactnum" value="<?php echo $contactold; ?>">
                	</content>
                	<content id="edit-btn-container">
                        <input type="submit" name="update" value="Update" class="btn btn-default">
                        <input type="submit" name="cancel" value="Cancel" class="btn btn-danger">
                	</content>
                </form>
            </div>
       </div>

    <!-- DONT -->
    </div>
		<footer>
			<p>A.Y. 2016-2017 Bookshare | &copy;CMSC 128 Lab Sec. 2 |  2016</p>
		</footer>
	</div>
</body>
</html>