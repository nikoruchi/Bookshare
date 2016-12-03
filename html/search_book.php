<?php	
		if(isset($_POST['submit'])){
			$search1=$_POST['search'];
			if(!empty($search1)){
				header("Location:result.php?ID=$search1");
			}else{
				header("Location:Library.php");
			}
		} ?>