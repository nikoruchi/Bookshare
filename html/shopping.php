<?php
    include("connect.php");
    session_start();
 		
 	   $acc_no=$_GET['id'];
       $sql = "SELECT * from cart where buyer_id = $acc_no and status=''";
       $result = $dbconn->query($sql);
       $row = $result->fetch_assoc();
       $count = $result->num_rows;
       echo $count;
       $dbconn->close();
?>