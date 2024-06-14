<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 4/29/2018
 * Time: 12:30 PM
 */

$db = oci_connect('77261069', '#Nepal@123.', '//localhost/xe');

function add_cart()
{
    global $db;
    if (isset($_GET['add_cart'])) {
        $quantity = $_POST['qty'];
        $id = $_GET['add_cart'];
        $ip = getRealUserIp();

		$check_product = "SELECT * FROM cart WHERE IP_ADD = '$ip' AND P_ID = '$id'";
		$run_check = oci_parse($db, $check_product);
		oci_execute($run_check);
		
		$row = oci_fetch_all($run_check, $output);
		if($row > 0)
		{
			echo "<script>alert('This product is already added in cart')</script>";
			echo "<script>window.open('product-details.php?eid='$id', '_self')</script>";	
		}
		else
		{

        $sql = "SELECT * FROM product where PRODUCT_ID = '$id'";
        $result = oci_parse($db, $sql);
        oci_execute($result);
        $row = oci_fetch_assoc($result);

        $price = $row['PRODUCT_PRICE'];


        $sql = "INSERT INTO cart (P_ID, IP_ADD, QTY, P_PRICE) VALUES ('$id','$ip','$quantity','$price')";

        $result = oci_parse($db, $sql);

        $result1 = oci_execute($result);
        oci_execute($result1);
        echo "<script>
				  window.open('product-details.php?eid = $id', 'self');
				  </script>";
				  
		}

    }
}


    function getRealUserIp(){
        switch(true){
            case (!empty($_SERVER['HTTP_X_REAL_IP'])) : return $_SERVER['HTTP_X_REAL_IP'];
            case (!empty($_SERVER['HTTP_CLIENT_IP'])) : return $_SERVER['HTTP_CLIENT_IP'];
            case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) : return $_SERVER['HTTP_X_FORWARDED_FOR'];
            default : return $_SERVER['REMOTE_ADDR'];
        }
    }
