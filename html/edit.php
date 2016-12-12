<?php
	include("connect.php");
  session_start();
	?>
<?php
    
      $account_id = $_SESSION['buyer_id'];
      $user_query= "SELECT * from account where account_id='$account_id'";
      $user_result=mysqli_query($dbconn, $user_query);
      $row_session = mysqli_fetch_assoc($user_result);
      $account_name = $row_session['account_name'];
      $user_name = $row_session['username'];
      $password = $row_session['password'];
      $year_level = $row_session['year_level'];
      $user_image = $row_session['account_imagepath'];
      $course = $row_session['course'];
      $query1 ="SELECT * FROM account_contacts where account_id='$account_id'";
      $result1 = mysqli_query($dbconn, $query1);
      $query2 ="SELECT * FROM account_emails where account_id='$account_id'";
      $result2 = mysqli_query($dbconn, $query2);
      $msg=false;
      $msgc=false;
      $query1 ="SELECT * FROM account_contacts where account_id='$account_id'";
      $result1 = mysqli_query($dbconn, $query1);
      $num_rows = mysqli_num_rows($result1);
      $mess = "";
    ?>
  <?php 
    if (isset($_GET['delete_id'])){
      header("Location:deletecontact.php");
    }
    if(isset($_GET['delete_email'])){
      header("Location:deleteemail.php");
    }
  ?>

<?php 

    if(isset($_POST['Cancel'])){
        header("url:Settings.php");
    }

    if(isset($_POST['add'])){ 
      $contact = $_POST['contact_number'];
      $emailz = $_POST['email'];
      $insertresult=FALSE;
      $insertresult1=FALSE;

      if($emailz!=''){
        $count = "SELECT * FROM account_emails WHERE account_id='$account_id'";
        $countresult = mysqli_query($dbconn, $count);
        if(mysqli_num_rows($countresult)>2){
            $msg=true;
            // ("Can't insert new email. Your email should be less than or equal to 3!");
        } else {
          $insert = "INSERT INTO account_emails (account_id, email) VALUES ('$account_id','$emailz')";
          $insertresult = mysqli_query($dbconn, $insert);
          // $msg=false;
        }
      }
      if($contact!=''){
        $count1 = "SELECT * FROM account_contacts WHERE account_id='$account_id'";
        $countresult1 = mysqli_query($dbconn, $count1);
        if(mysqli_num_rows($countresult1)>2){
          $msgc=true;
          // msg("Can't insert new contact number. Your contact number should be less than or equal to 3!");
        }
         else if(!preg_match('/^[\+639|09]([0-9]{9}/',$contact)) {
          if($msgc==true){
            $msgc;
          }
          else{
            $msgc = true;
          }
         }
         else {
          $insert1 = "INSERT INTO account_contacts (account_id, contact_number) VALUES ('$account_id','$contact')";
          $insertresult1 = mysqli_query($dbconn, $insert1);
           // $msgc=false;
        }
      }
      if($insertresult1||$insertresult){
        header("Refresh:0");
      }
    }

  if(isset($_POST['Save'])){
      $name = $_POST['name'];
      $user_name = $_POST['user_name'];
      $yearlevel = $_POST['yearlevel'];
      $course1 = $_POST['course1'];

      if($yearlevel==''){
        $yearlevel = $year_level;
      }
      if($course1==''){
        $course1 = $course;
      }

      $sql = "UPDATE account SET account_name='$name', username='$user_name', year_level='$yearlevel', course='$course1' WHERE account_id='$account_id'";
      if(mysqli_query($dbconn, $sql)){
        if($user_name!=$account_name){
          $_SESSION['username']=$user_name;
        }
        $mess = "Changes Saved! ";
        header("Refresh:0");
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
	   <a href="Settings.php"><h1 id="bookshelf">Account Settings</h1></a>
      <span id = "error"><p style="color:green; font-size:25px; padding:10px;"><?php echo $mess; ?></p></span>

      <div class="edit_set_section well well-sm " >

            <div id="edit_data">
            <h2 id="sections">PERSONAL DATA:</h2>
            <form method="post" action="<?php $_PHP_SELF; ?>" >
                <content class="col-xs-set">
                    <label id="name">Name:</label>
                    <input class="form-control-set" type="text" name="name" value="<?php echo $account_name; ?>">
                    <label id="user">Username:</label>
                    <input class="form-control-set" type="text" name="user_name" value="<?php echo $user_name; ?>">                    
                </content>
                 <content class="col-xs-set">
                    <label id="year">Year:</label>
                    <select name="yearlevel" id="yearlevel" class="form-control-set">     
                      <option value=""> </option>
                      <option value="1st_year" <?php if (isset($year_level) && $year_level=="1st_year") echo "selected";?>> 1st Year </option>
                      <option value="2nd_year" <?php if (isset($year_level) && $year_level=="2nd_year") echo "selected";?>> 2nd Year </option>          
                      <option value="3rd_year" <?php if (isset($year_level) && $year_level=="3rd_year") echo "selected";?>> 3rd Year </option>
                      <option value="4th_year" <?php if (isset($year_level) && $year_level=="4th_year") echo "selected";?>> 4th Year </option>
                      <option value="5th_year" <?php if (isset($year_level) && $year_level=="5th_year") echo "selected";?>> 5th Year </option>
                      <option value="nth_year" <?php if (isset($year_level) && $year_level=="nth_year") echo "selected";?>> nth Year </option>
                      <option value="masters_1" <?php if (isset($year_level) && $year_level=="masters_1") echo "selected";?>> Master I </option>
                      <option value="masters_2" <?php if (isset($year_level) && $year_level=="master_2") echo "selected";?>> Master II </option>
                      <option value="doctors" <?php if (isset($year_level) && $year_level=="Doctorate") echo "selected";?>> Doctorate </option>
                    </select>
                </content>
                <content class="col-xs-set">
                    <label id="year">Course:</label>
                    <select name="course1" id="course1" class="form-control-set">      
                      <option value="">  </option>
                      <option value="Accountancy" <?php if (isset($course) && $course=="Accountancy") echo "selected";?>> Accountancy </option>
                      <option value="Applied Mathematics" <?php if (isset($course) && $course=="Applied Mathematics") echo "selected";?>> Applied Mathematics </option>         
                      <option value="Biology" <?php if (isset($course) && $course=="Biology") echo "selected";?>> Biology </option>
                      <option value="Business Administration" <?php if (isset($course) && $course=="Business Administration") echo "selected";?>> Business Administration </option>
                      <option value="Chemical Engineering" <?php if (isset($course) && $course=="Chemical Engineering") echo "selected";?>> Chemical Engineering </option>
                      <option value="Chemistry" <?php if (isset($course) && $course=="Chemistry") echo "selected";?>> Chemistry </option>
                      <option value="Communication And Media Studies" <?php if (isset($course) && $course=="Communication And Media Studies") echo "selected";?>> Communication and Media Studies </option>
                      <option value="Community Development" <?php if (isset($course) && $course=="Community Development") echo "selected";?>> Community Development </option>
                      <option value="Computer Science" <?php if (isset($course) && $course=="Computer Science") echo "selected";?>> Computer Science </option>
                      <option value="Economics" <?php if (isset($course) && $course=="Economics") echo "selected";?>> Economics </option>
                      <option value="Fisheries" <?php if (isset($course) && $course=="Fisheries") echo "selected";?>> Fisheries </option>
                      <option value="Food Technology" <?php if (isset($course) && $course=="Food Technology") echo "selected";?>> Food Technology </option>
                      <option value="History" <?php if (isset($course) && $course=="History") echo "selected";?>> History </option>
                      <option value="Literature" <?php if (isset($course) && $course=="Literature") echo "selected";?>> Literature </option>
                      <option value="Management" <?php if (isset($course) && $course=="Management") echo "selected";?>> Management </option>
                      <option value="Political Science" <?php if (isset($course) && $course=="Political Science") echo "selected";?>> Political Science </option>
                      <option value="Psychology" <?php if (isset($course) && $course=="Psychology") echo "selected";?>> Psychology </option>
                      <option value="Public Health" <?php if (isset($course) && $course=="Public Health") echo "selected";?>> Public Health </option>
                      <option value="Sociology" <?php if (isset($course) && $course=="Sociology") echo "selected";?>> Sociology </option>
                      <option value="Statistics" <?php if (isset($course) && $course=="Statistics") echo "selected";?>> Statistics </option>
                    </select>
                </content>
                <content class="col-xs-set" id="edit-btn-container">
                        <input type="submit" name="Save" value="Save" class="btn btn-default">
                        <a href="Settings.php" class="btn btn-danger"> Cancel </a> 
                </content>
            </form>
            </div>
            <div id="edit_data2">
            <div id="contact_set">
                <h2 id="sections">CONTACT INFORMATION</h2>
            </div>
            
            <section id="error">
            <?php 
              if($msgc==true){?>    
                <p>"Can't insert new contact number. Your contact number should match the given pattern and could only have a maximum of 3 contact numbers"</p>
            <?php } 
              if($msg==true){?>    
                <p>Can't insert new email. You could only have a maximum of 3 emails.!</p>
            <?php } 
              elseif(!($msg==true)||!($msgc==true)){?>
                <p><br></p>
            <?php } 
               elseif(!($msg==true)||!($msgc==true)){?>
                <p><br></p>
            <?php }

              if(isset($_GET['succ'])){
                $success = $_GET['succ'];
                  if($success == "contact"){?>
                   <p style = "color:green;">Your contact number was successfully updated</p>
                  <?php }

                   elseif ($success == "email") {?>
                      <p style = "color:green;">Your email was successfully updated</p>
                    <?php }
                    elseif($success=="email_delete"){?>
                        <p style = "color:green;">Your email was successfully deleted</p>
                    <?php }
                    elseif($success=="contact_delete"){?>
                        <p style = "color:green;">Your email was successfully deleted</p>
                    <?php }
                    } 
                
              
                ?>

              

            </section>

            <div class="add_btn_container">
                <button type="button" class="btn btn-info btn-primary" name="add" data-toggle="modal" data-target="#myModal">+Add</button>
            </div>
                <label id="number">Contact Number/s:</label> 

       <?php      
         
         
         while($row1 = mysqli_fetch_array($result1)){ 
                        $contact_number=$row1['contact_number'];?>
                        <div class="list" id="multi_inputs">
                            <content><?php echo $contact_number; ?></content> 
                            <a id="action" style="color:green;" class="btn-link" name="update" href="updatecontact.php?ID=<?php echo $row1['contact_id']?>">Update</a>  
                            <a  style="color:red;" href="javascript:delete_id(<?php echo $row1['contact_id']; ?>)">Delete</a>
                        </div>
       <?php    } 
       ?>

             <label id="email">Email/s:</label> 
       <?php        while($row1 = mysqli_fetch_assoc($result2)){ 
                        $email = $row1['email'];?>
                            <div id="multi_inputs">
                                <content><?php echo  $email; ?></content>
                                <a id="action" style="color:green;" class="btn-link" href="updateemail.php?ID=<?php echo $row1['email_id']?>">Update</a>
                                <a style="color:red;" class="btn-link" href="javascript:delete_email(<?php echo $row1['email_id']; ?>)">Delete</a> 
                            </div>
       <?php    } ?>
            </div>
       </div>


<!-- MODAAAAAAAAAAAAAAAAALS -->
<!-- ADD MODAL -->
    <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
      <form method="post" action="<?php $_PHP_SELF; ?>">
        <div class="modal-header">
          <h4 class="modal-title">Add a Contact Number or Email</h4>
        </div>
        <div class="modal-body">
             <span class="box">
                <div id="number_modal"> 
                   <label id="modal_label">Contact Number:</label>
                   <input class="form-control-set" type="number" name="contact_number">
                </div>
                <div>
                   <label id="modal_label">Email:</label>
                   <input type="email" class="form-control-set" name="email" placeholder="admin@gmail.com">
                </div>
             </span>
        </div>
        <div class="modal-footer">
            <input type="submit" name="add" value="Save" class="btn btn-default">
            <input type="reset" name="cancel" value="Cancel" class="btn btn-danger" data-dismiss="modal">
        </div>
        </form>
      </div>
      
    </div>
  </div>


    <!-- DONT -->
    </div>

  

  

   <script type="text/javascript">
      function delete_id(id)
      {
        if(confirm('Sure To Remove Contact Number?'))
        {
          window.location.href='deletecontact.php?delete_id='+id;
        }
      }
  </script>
  <script type="text/javascript">
      function delete_email(id)
      {
        if(confirm('Sure To Remove This Email?'))
        {
          window.location.href='deleteemail.php?delete_email='+id;
        }
      }
  </script>
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
  var id = <?php echo json_encode($account_id);?>;  
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

