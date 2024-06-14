<?php
	session_start();
	if(isset($_SESSION['USER_ID'])){
	$USER_ID = $_SESSION['USER_ID'];	
	}else{
		header('location:../login.php');
	}
	include '../core/connection.php';
	if(isset($_GET['sid'])){		
		$sid = $_GET['sid'];
		$detail = "SELECT * FROM EUSER WHERE USER_ID = $sid";
		$detailqry = oci_parse($conn, $detail);
		oci_execute($detailqry);
		while($row = oci_fetch_assoc($detailqry)){
			$active = $row['ACTIVE'];
			$email = $row['USER_EMAIL'];			
		}
		if($active==1){
			//deactivate
			$sql = "UPDATE EUSER SET ACTIVE = '0' WHERE USER_ID = $sid";
			$qry = oci_parse($conn, $sql);		
			$ociExecute = oci_execute($qry);
			$msg = "Your account has been deactivated, please contact the admin for more info";

			// use wordwrap() if lines are longer than 70 characters
			$msg = wordwrap($msg,70);
		
				
			$headers = "From: brontetbc@gmail.com\r\n";
			$headers .= "Reply-To: ".$email."\r\n";
			$headers .= "Return-Path: brontetbc@example.com\r\n";

			if ( mail($email,"About your account",$msg,$headers) ) {
   				echo "Confirmation has been sent to trader's email";
   			} 
			else 
			{
   				echo "Failed to send email to trader, try again!";
   			}
			if(!$ociExecute){
				echo "<script>alert('Oci Execute Error');window.location.href='managetraders.php';</script>";
			}else{
				echo "<script>alert('You have sucessfully Deactivated a Trader.');window.location.href='managetraders.php';</script>";
			}
			
		}else{
			//activate
			$sql = "UPDATE EUSER SET ACTIVE = '1' WHERE USER_ID = $sid";
			$qry = oci_parse($conn, $sql);		
			$ociExecute = oci_execute($qry);
			
			$msg = "Your account has been activated";

			// use wordwrap() if lines are longer than 70 characters
			$msg = wordwrap($msg,70);
		
				
			$headers = "From: brontetbc@gmail.com\r\n";
			$headers .= "Reply-To: ".$email."\r\n";
			$headers .= "Return-Path: brontetbc@example.com\r\n";

			if ( mail($email,"About your account",$msg,$headers) ) {
   				echo "Confirmation has been sent to trader's email";
   			} 
			else 
			{
   				echo "Failed to send email to trader, try again!";
   			}
			
			
			if(!$ociExecute){
				echo "<script>alert('Oci Execute Error');window.location.href='managetraders.php';</script>";
			}else{
				echo "<script>alert('You have sucessfully Activated a Trader.');window.location.href='managetraders.php';</script>";
			}
		}	
	}
?>