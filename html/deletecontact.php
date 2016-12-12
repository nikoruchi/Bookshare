<?php
	include("connect.php");
	session_start();

?>
<?php
		
	if(isset($_GET["delete_id"])){        		
		$get_id = $_GET["delete_id"];   	
	}
            
    $sql = "DELETE FROM account_contacts WHERE contact_id='$get_id'";
            
    if (mysqli_query($dbconn, $sql)) {
    	$success = "contact_delete";
       	header("Location:edit.php?succ=$success");
	} else {
?>
		<p>Error: </p>
<?php
    	echo $sql.mysqli_error($dbconn);
	} 
    
    //closing bookshare connection
        mysqli_close($dbconn);
	?>
