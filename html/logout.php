<?php
	session_start();
	session_unset();
	// $_SESSION['username']='';
	// $_SESSION['buyer_id']='';
	if(session_destroy()){
		header("Location:index.php");
	}
?>