<?php
//include("connect.php");
//session_start();
?>

<!DOCTYPE html5>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="CMSC 128 Lab Sec. 2">
	<meta name="description" content="Sell, buy, and trade books with your schoolmates.">
	<meta name="keywords" content="Book, Books, Sell Book, Buy Book">
	<title>Welcome to BookShare!</title>

	<link rel="shortcut icon" href="../images/official_logo.png">
	<link rel="stylesheet" type="text/css" href="../css/welcoming.css">
</head>
<body>
<div class="filter">
	<h1 id="welcome_header">Welcome to Bookshare!</h1>
	<span id="header_desc">Buy and sell books in the fastest and simplest way <br> with your fellow schoolmates.</span>


	<section id="video_position">
			<video height="auto" width="100%" autoplay loop>
				<source src="../images/lib.mp4" type="video/mp4">
				Your browser...please change it.
			<video>
	</section>
	
	<section>	
		<img id="img_pos" src="../images/TEST.png" alt="No image" title="login/signup_box"/>
	</section>
	
	<span id="log_header">Already have an account?</span>
	<a href="login.php"><img id="log_pos" class="log_sign" src="../images/login.png"></a>
	<span id="sign_header">New here?</span>
	<span id="sign_header1"> Create a new account.</span>
	<a href="signup.php"><img id="sign_pos" class="log_sign" src="../images/signup.png"></a>

	<footer>
		Copyright(C)2016. CMSC 128 Laboratory - Section 2. S.Y. 2016-2017. University of the Philippines Visayas.
	</footer>
</div>
</body>
</html>
