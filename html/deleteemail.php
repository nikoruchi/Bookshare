<?php
	include("connect.php");
	session_start();
?>

<?php

	if(isset($_GET["ID"])){        		
		$get_id = $_GET["ID"];   	
	}
            
    $sql = "DELETE FROM account_emails WHERE email_id='$get_id'";
            
    if (mysqli_query($dbconn, $sql)) { 
        header("Location:edit.php");
	} else {
	?>
		<p>Error: </p>
	<?php
    	echo $sql.mysqli_error($dbconn);
	} 
    
    //closing bookshare connection
        mysqli_close($dbconn);
?>
