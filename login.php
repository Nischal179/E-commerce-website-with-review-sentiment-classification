<?php
include 'core/connection.php';
include 'includes/functions.php';


if(isset($_POST['submit'])){
	$user_email = $_POST['email'];
	$pass = $_POST['password'];
	$pass =  $pass ;

	
	$detail = "SELECT * FROM EUSER WHERE user_email = '$user_email' AND user_password = '$pass'";
	$detailqry = oci_parse($conn, $detail);	
	oci_execute($detailqry);	
	while($row = oci_fetch_assoc($detailqry)){
		$uid = $row['USER_ID'];
		$fname = $row['USER_FIRST_NAME'];
		$lname = $row['USER_LAST_NAME'];
		$type = $row['USER_TYPE'];
		$active = intval($row['ACTIVE']);
	}
	
	if(oci_num_rows($detailqry) !=0){
		if($active==1){
			session_start();			
			$_SESSION['USER_ID'] = $uid;
			$_SESSION['USER_TYPE'] = $type;
			$ip_add = getRealUserIp();
			
			$sql = "SELECT * FROM CART WHERE ip_add = '$ip_add'";
			$qry = oci_parse($conn, $sql);
			oci_execute($qry);			
			while($row = oci_fetch_array($qry)){
				$pdtid = $row['P_ID'];
				
				$hasPrdt = false;
				$sql2 = "SELECT * FROM CART WHERE P_ID = '$pdtid' AND USERID= '$uid'";
				$qry2 = oci_parse($conn, $sql2);
				oci_execute($qry2);			
				while($row2 = oci_fetch_array($qry2)){
					$hasPrdt = true;
				}
				if(!$hasPrdt){
					$sql1 = "UPDATE CART SET USERID='$uid', ip_add = '' WHERE P_ID='$pdtid'";
					$qry1 = oci_parse($conn, $sql1);
					oci_execute($qry1);
				}else{
					$sql2 = "DELETE FROM CART WHERE P_ID = '$pdtid' AND ip_add= '$ip_add'";
					$qry2 = oci_parse($conn, $sql2);
					oci_execute($qry2);
				}
				
			}
			
			if(strtoupper($type)=="CUSTOMER"){
				header('location:index.php');
			}else if(strtoupper($type)=="TRADER"){
				header('location:trader/home.php');
			}else if(strtoupper($type)=="ADMIN"){
				header('location:admin/home.php');			
			}else{
				echo "<script language='javascript'>;alert('USER DATATYPE MISMATCHED.')</script>;";
			}
		}else{
			echo "<script language='javascript'>;alert('Your Account Is Not Active. Please Contact your Administrator.')</script>;";			
		}
		
		
	}else{
		echo "<script language='javascript'>;alert('Invalid login credentials!')</script>;";
	}
		
}
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ShopHub | Registration Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 --> 
  <link type="text/css" rel="stylesheet" href="misc/css/bootstrap.min.css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="misc/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="assets/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="assets/plugins/iCheck/square/blue.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
	<!-- /top Header -->
	<div class="container" id="logo">
		<div class="container">
			<div class="pull-left">			
			</div>
		</div>
	</div>
	
<body class="hold-transition">
<style>
#login {
    border: 0px solid;
    padding: 10px;
    box-shadow: 0 0 5px #888888;
	background-color: #ffffff;
}
#logo {
	width: 100%;
	background-color: #ffffff;
}

body {
    background-color: #f9f9f9;
}
</style>
<div class="login-box" id="login">
  <div class="login-logo">
    <a href="index.php"><span style="color: #C0282E">Shop</span><b>Hub</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox">
            
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    

    <a href="forgotpass.php">I forgot my password</a><br>
    <a href="register.php" class="text-center">Register a new membership</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="assets/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="assets/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="assets/plugins/iCheck/icheck.min.js"></script>

</body>
</html>