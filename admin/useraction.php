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
		}
		if($active==1){
			//deactivate
			$sql = "UPDATE EUSER SET ACTIVE = '0' WHERE USER_ID = $sid";
			$qry = oci_parse($conn, $sql);		
			oci_execute($qry);
			if(ociError()){
				echo "<script>alert('Oci Execute Error');window.location.href='manageusers.php';</script>";
			}else{
				echo "<script>alert('You have sucessfully Deactivated a User.');window.location.href='manageusers.php';</script>";
			}
			
		}else{
			//activate
			$sql = "UPDATE EUSER SET ACTIVE = '1' WHERE USER_ID = $sid";
			$qry = oci_parse($conn, $sql);		
			oci_execute($qry);
			if(ociError()){
				echo "<script>alert('Oci Execute Error');window.location.href='manageusers.php';</script>";
			}else{
				echo "<script>alert('You have sucessfully Activated a User.');window.location.href='manageusers.php';</script>";
			}
		}	
	}
?>