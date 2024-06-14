<?php
session_start();
if(isset($_SESSION['USER_ID'])){
	$USER_ID = $_SESSION['USER_ID'];	
}else{
	header('location:../login.php');
}
include ('imageupload.php');
include ('../../connection.php');
	if(isset($_GET['id'])){
    	$eid = $_GET['id'];
		$details = "DELETE FROM PRODUCT WHERE PRODUCT_ID = '$eid'";
   		$detailqry = oci_parse($conn, $details);
		oci_execute($detailqry); 
		header("Location: {$_SERVER['HTTP_REFERER']}");
	}

?>