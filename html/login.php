<?php
	include("connect.php");
	session_start();


	$counter = 0;
	$errormsg = ""; //so no error will show

	if(isset($_POST['Submit'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$query = "SELECT * FROM account WHERE username='$username' AND password=MD5('$password')";
		$result = mysqli_query($dbconn, $query);
        if($username == null && $password == null){
			$errormsg = "Please enter both fields!";
		} elseif($username == null && !($password == null)) {
			$errormsg = "Please enter username!";
		} elseif(!($username == null) && $password == null) {
			$errormsg = "Please enter password!";
        } elseif(mysqli_num_rows($result) == 0) {
           	$errormsg = "Sorry wrong username/password.";
       	} else {
           	$_SESSION["username"] = $_POST["username"];
           	while(list($account_id,$account_name,$username,$password,$email,$year_level,$course,$account_imagepath)=mysqli_fetch_row($result)){
           		$_SESSION["buyer_id"]=$account_id;
           		$_SESSION["username"]=$username;
           	}
           	header("Location:./profile.php ");
        }
    }
	if (isset($_POST['Cancel'])){
		header("location:./index.php");
	}

	if(isset($_SESSION["username"])){
			//header("Location:./profile.php ");
	}

	mysqli_close($dbconn);
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="author" content="CMSC 128 Lab Sec. 2">
	<meta name="description" content="Sell, buy, and trade books with your schoolmates.">
	<meta name="keywords" content="Book, Books, Trade Book, Sell Book, Buy Book">
	<title>Login!</title>

	<link rel="shortcut icon" href="../images/official_logo.png">
	<link rel="stylesheet" type="text/css" href="../css/welcoming2.css">
</head>

<body class="login_body">
	<h1> Log-in to Bookshare</h1>
	
	<div class="form_container1">
	
	<div class="form_placement1">
	
		<form method="post" action="<?php $_PHP_SELF?>">
		<p id="errormsg"><?=$errormsg;?></p> 		
		<span id="input" class="col-xs-4">	
			<label for="username">Username</label>
			<input type="text" name="username" id="name" placeholder="Username" autofocus class="form-control"> <br><br>
		</span>
		<span id="input" class="col-xs-4">
			<label for="password">Password</label>
			<input type="password" name="password" id="password" placeholder="Password" class="form-control"> <br><br>
		</span>
	</div>
	<div class="btn-placement1">
		<input type="submit" name="Submit" value="Log-in" class="btn btn-default">
		<input type="submit" name="Cancel" value="Cancel" class="btn btn-danger">
		<content id="redirect_placement">
			New here? Create an account. 
			<a href="signup.php" id="link_back">SIGN-UP</a>
		</content>
	</div>
	</form>
	</div>
</body>
</html>