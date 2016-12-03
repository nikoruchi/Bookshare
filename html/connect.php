<?php 

	// if(!isset($_SESSION['username'])){
	// 	header("Location:index.php");
	// }

	$host = 'localhost';  
	$username = 'root'; 
	$password = ''; 
	$db = 'bookshare_v3'; 
	$dbconn = mysqli_connect($host,$username,$password) or die("Could not connect to database!");
	mysqli_select_db($dbconn, $db) or die( "Unable to select database"); 

	
	//selecting bookshare_v3
	mysqli_select_db($dbconn,$db);

?>	
