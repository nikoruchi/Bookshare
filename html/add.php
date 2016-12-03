	<?php

	include("connect.php");
	session_start();

		//$query = "SELECT * FROM account";
		//$result = mysqli_query($dbconn, $query);
		//$row = mysqli_fetch_assoc($result);
		//$account_id = $row['account_id'];
		
		$account_id = $_SESSION['buyer_id'];
		$query1 = "SELECT * FROM account_contacts where account_id='$account_id'"; 
		$result1 = mysqli_query($dbconn, $query1);
		$row1 = mysqli_fetch_assoc($result1);
	
		if(isset($_POST['add'])){ 
			$contact = $_POST['contact_number'];
			$emailz = $_POST['email'];

			if($emailz!=''){
			$insert = "INSERT INTO account_emails (account_id, email) VALUES ('$account_id','$emailz')";
			$insertresult = mysqli_query($dbconn, $insert);
			}
			if($contact!=''){
			$insert1 = "INSERT INTO account_contacts (account_id, contact_number) VALUES ('$account_id','$contact')";
			$insertresult1 = mysqli_query($dbconn, $insert1);
			}
			
			if($insertresult || $insertresult1){
				header("Location:edit.php");
			}

		}
		if(isset($_GET['cancel'])){
			header("Location:edit.php");
		}
	?>
