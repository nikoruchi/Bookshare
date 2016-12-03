<?php 
include("connect.php");
session_start();

$picpath = "user_pic.jpg";
?>
<!DOCTYPE html5>
<html>
	<head>
		<title>Sign-Up!</title>
		<link rel="shortcut icon" href="../images/official_logo.png">
		<link rel="stylesheet" type="text/css" href="../css/welcoming2.css">o
	</head>

<body>
	<h1 id="h1_signup"> Join Bookshare </h1>
	<div class="form_container">
	<div class="form_placement">
	<form method="post" action="<?php $_PHP_SELF?>" enctype="multipart/form-data">
	<div class="upload_center">
		<div class="edit_user_pic_section">
			<img id="user_pic" src="../images/<?=$picpath;?>" width="125" height="125" alt="user photo">
			<label class="fileUpload btn btn-success">    
            	<span class="upload">Upload</span> 
            	<input type="file" name="pic-upload" id="pic-upload" />
          	</label>
		</div>
	</div>	
		<section id="errormsg2">
		<!--PHP-->
		<?php
			$empty = "";

			$checkuser=$checkpass=$checkretype=false;
			
			if(isset($_POST['submit'])) {
				$name = $_POST["name"];
				$uname = $_POST["newuser"];
				$email = $_POST["email"];
				$num = $_POST["num"];
				$level = $_POST["year_level"];
				$course = $_POST["course"];
				$pass = $_POST["newpassword"];
				$pass1 = $_POST["newpassword1"];

				if($name == null || $uname == null || $email == null || $num == null || $level == null || $course == null || $pass == null || $pass1 == null){ 		
			        msg("*You must fill out all the fields.");			         	
				}else{
			        $sql = "SELECT * FROM account WHERE BINARY username LIKE '$uname'";
			        $re = mysqli_query($dbconn, $sql);
			        if(mysqli_num_rows($re)>0){
						msg("*Sorry Username " .$uname." has already been taken!");
					}else{
						$checkuser=true;
			        }
			        if(!preg_match('/(?=.*\d)[A-Za-z\d]{6,}/', $pass) || !preg_match('/(?=.*\d)[A-Za-z\d]{6,}/', $pass1)){
		        		msg("*Password must at least be 6 characters long and should contain at least 1 integer.");
		        	}
		        	else{
						$checkpass=true;
		        	}
					if($pass1 != $pass){
	        			msg("*Oops, password and confirmation don’t match!");	
	        		}
	        		else{
						$checkretype=true;
	        		}
	        		if($checkuser&&$checkpass&&$checkretype){
						$query = "INSERT INTO account (account_name, username, password, year_level, course) VALUES ('$name', '$uname', MD5('$pass'), '$level', '$course')";
						if(mysqli_query($dbconn, $query)){
							$que = "SELECT * FROM account WHERE BINARY username LIKE '$uname'";
							$res1 = mysqli_query($dbconn, $que);
							while(list($account_id,$account_name,$username,$password,$year_level,$course,$account_imagepath) = mysqli_fetch_row($res1)){
								$id = $account_id;
								$usname = $username;
							}
							$quer = "INSERT INTO account_contacts (account_id, contact_number) VALUES ('$id', '$num')";
							if(mysqli_query($dbconn, $quer)){
								$querr = "INSERT INTO account_emails (account_id, email) VALUES ('$id', '$email')";
								if(mysqli_query($dbconn, $querr)){
									$_SESSION["buyer_id"]=$id;
									$_SESSION["username"]=$usname;
								}
							}
							//diri na mag-add image
							if(!empty(basename($_FILES["pic-upload"]["name"]))){
								$target_dir = "../uploads/";
								$target_file = $target_dir . basename($_FILES["pic-upload"]["name"]);
								$uploadOk = 1;
								$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

								$check = getimagesize($_FILES["pic-upload"]["tmp_name"]);
							    if($check == false){
							        msg("File is not an image.");
							        $uploadOk = 0;
							    }

							    // Check if file already exists
								if (file_exists($target_file)) {
								    $target_file = $target_dir ."00". basename($_FILES["pic-upload"]["name"]);
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
								// if everything is ok, try to upload file
								if ($uploadOk == 1) {
									if (move_uploaded_file($_FILES["pic-upload"]["tmp_name"], $target_file)) {
								       $sql = "UPDATE account SET account_imagepath = '$target_file' WHERE account_id='$id'";
								    }
								}
							} else {
								$target_file="../uploads/".$picpath;
								$sql = "UPDATE account SET account_imagepath = '$target_file' WHERE account_id='$id'";
							}
							$add_image= mysqli_query($dbconn, $sql); 
							header("location:./profile.php"); //redirects to page congratulating making user choose to go to login   
						}
							
					}
				}
			} else {
				msg($empty);
			}
			
		if (isset($_POST['Cancel'])){
			header("Location:./index.php");
		}
		
		
		function msg($mess){?>		
		<p><?=$mess;?></p>
		<?php } ?>
	
		</section>
		<div id="input_types">
			<span id="input" class="col-xs-4">
				<label for="name">Full Name: </label>
				<input type="text" id="name" name="name" class="form-control">
			</span>
			<span id="input" class="col-xs-4">
				<label for="Username">Username: </label> 
				<input type="text" id="newuser" name="newuser" class="form-control">
			</span>
			<span id="input" class="col-xs-4">
				<label for="email">E-mail: </label>
				<input type="email" id="email" name="email" class="form-control">
			</span>
			<span id="input" class="col-xs-4">
				<label for="num">Contact Number: </label>
				<input type="text" id="num" name="num" class="form-control">
			</span>
			<span id="input" class="col-xs-4">	
				<label for="year_level">Year Level: </label>  <!--- Dropdown dapat ang YEAR LEVEL and COURSE -->
				<select name="year_level" id="year_level" class="form-control">			
					<option value=" "> </option>
					<option value="1st_year"> 1st Year </option>
					<option value="2nd_year"> 2nd Year </option>			   	
					<option value="3rd_year"> 3rd Year </option>
					<option value="4th_year"> 4th Year </option>
					<option value="5th_year"> 5th Year </option>
					<option value="nth_year"> nth Year </option>
					<option value="masters_1"> Master I </option>
					<option value="masters_2"> Master II </option>
					<option value="doctors"> Doctorate </option>
				</select>
			</span>
			<span id="input" class="col-xs-4">
				<label for="course">Course: </label>
				<select name="course" id="course" class="form-control">			
					<option value=" ">  </option>
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
			</span>
			<span id="input" class="col-xs-4">
				<label for="NewPassword">Password: </label>
				<input type="password" id="newpassword" name="newpassword" class="form-control">
			</span>
			<span id="input" class="col-xs-4">
				<label for="RetypeNewPassword">Re-type New Password: </label>
				<input type="password" id="retypenewpassword" name="newpassword1" class="form-control">
			</span>
		</div>
	
	<div class="btn-placement">
		<input type="submit" name="submit" value="Sign-up" class="btn btn-default">
		<input type="submit" name="Cancel" value="Cancel" class="btn btn-danger">
			<content id="redirect_placement">
			Already have an account? 
			<a href="login.php" id="link_back">LOG-IN</a>
		</content>
	</div>
	</div> 
	</form>
	</div>
	</body>
		

</html>
