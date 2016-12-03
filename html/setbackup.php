<?php
	include("connect.php");
	include("search_book.php");
    include("add.php");
    include("updatecontact.php");
  session_start();
	?>
<?php
    
      $query = "SELECT * FROM account";
      //$account_id = $_SESSION['account_id'];
      $account_id = 1;
      $user_query= "SELECT * from account where account_id='$account_id'";
      $user_result=mysqli_query($dbconn, $user_query);
      $row_session = mysqli_fetch_assoc($user_result);
      $account_name = $row_session['account_name'];
      $user_name = $row_session['username'];
      $password = $row_session['password'];
      //$email = $row_session['email'];
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
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="CMSC 128 Lab Sec. 2">
	<meta name="description" content="Sell, buy, and trade books with your schoolmates.">
	<meta name="keywords" content="Book, Books, Trade Book, Sell Book, Buy Book">
	<title> Settings </title>

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
                  <img src="<?php echo $_SESSION['imagepath']?>" title="Profile" alt="Profile" height="40" width="40" id="logo2">
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
	   <h1 id="bookshelf">Settings</h1>
      <div class="edit_set_section well well-sm " >

            <form action="edit.php" method="post" >  
            <div id="edit_data">
            <h2 id="sections">PERSONAL DATA:</h2>
                <content class="col-xs-set">
                    <label id="name">Name:</label>
                    <input class="form-control-set" type="text" name="user_name" value="<?php echo $account_name; ?>">
                    <label id="user">Username:</label>
                    <input class="form-control-set" type="text" name="user_name" value="<?php echo $user_name; ?>">
                    <label id="password">Password:</label>
                    <input class="form-control-set" type="password" name="password" value="<?php echo $password; ?>"> 
                </content>
                <content class="col-xs-set">
                    <label id="year">Year:</label>
                    <input class="form-control-set" type="text" name="year_level" value="<?php echo  $year_level; ?>">
                </content>
                <content class="col-xs-set">
                    <label id="year">Course:</label>
                    <input class="form-control-set" type="text" name="course" value="<?php echo  $course; ?>">
                </content>
                <content class="col-xs-set" id="edit-btn-container">
                        <input type="submit" name="Save" value="Save" class="btn btn-default">
                        <input type="reset" name="Cancel" value="Cancel" class="btn btn-danger" >
                </content>
            </div>
            <div id="edit_data2">
            <div id="contact_set">
                <h2 id="sections">CONTACT INFORMATION</h2>
            </div>
            <div class="add_btn_container">
                <button type="button" class="btn btn-info btn-primary" name="add" data-toggle="modal" data-target="#myModal">+Add</button>
            </div>
                <label id="number">Contact Number/s:</label> 
       <?php        while($row1 = mysqli_fetch_assoc($result1)){ 
                        $contact_number=$row1['contact_number'];?>
                        <div id="multi_inputs">
                            <content><?php echo $contact_number; ?></content> 
                            <a id="action" style="color:green;" class=" btn-link" name="update">Update</a>  
                            <a id="action" style="color:red;" class=" btn-link">Delete</a>
                        </div>
       <?php    } ?>

                <label id="email">Email/s:</label> 
       <?php        while($row1 = mysqli_fetch_assoc($result2)){ 
                        $email = $row1['email'];?>
                            <div id="multi_inputs">
                                <content><?php echo  $email; ?></content>
                                <a id="btn_email" style="color:green;" class=" btn-link">Update</a>
                                <a id="action" style="color:red;" class=" btn-link">Delete</a> 
                            </div>
       <?php    } ?>
            </div>
      </form>
       </div>



    <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
      <form method="post" action="<?php $_PHP_SELF; ?>" >
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add a Contact Number or Email</h4>
        </div>
        <div class="modal-body">
          <p> 
             <content class="col-xs-set">
                   <label id="year">Contact Number:</label>
                   <input class="form-control-set" type="text" name="contact_number">
                   <label id="year">Email</label>
                   <input class="form-control-set" type="text" name="email">
             </content>
          </p>
        </div>
        <div class="modal-footer">
            <input type="submit" name="add" value="Save" class="btn btn-default">
            <input type="reset" name="Cancel" value="Cancel" class="btn btn-danger" data-dismiss="modal">
        </div>
        </form>
      </div>
      
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