<?php
	session_start();
	if(isset($_SESSION['USER_ID'])){
	$USER_ID = $_SESSION['USER_ID'];	
	}else{
		header('location:../login.php');
	}
	include ('../core/connection.php');
	if(isset($_GET['sid'])){
		$sid = $_GET['sid'];
		$sql2 = "DELETE FROM PRODUCT_CATEGORY WHERE CATEGORY_ID=$sid";
		$result2 = oci_parse($conn,$sql2);
		oci_execute($result2);
		//header("Location: {$_SERVER['HTTP_REFERER']}");
		$location = $_SERVER['HTTP_REFERER'];
		echo "<script>alert('You have sucessfully Deleted a Product Category.');window.location.href='$location';</script>";
	}
		
?>