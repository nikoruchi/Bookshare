<?php
	include("connect.php");
	session_start();
?>

<?php
	$succ = "";

	if(isset($_GET["delete_email"])){        		
		$get_id = $_GET["delete_email"];   	
	}
            
    $sql = "DELETE FROM account_emails WHERE email_id='$get_id'";
            
    if (mysqli_query($dbconn, $sql)) { 
    	$succ = "email_delete";
        header("Location:edit.php?$succ");
	} else {
	?>
		<p>Error: </p>
	<?php
    	echo $sql.mysqli_error($dbconn);
	} 
    
    //closing bookshare connection
        mysqli_close($dbconn);
?>
