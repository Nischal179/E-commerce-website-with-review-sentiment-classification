<?php
include 'core/connection.php';


if(isset($_POST['submit']))
{
	$username = $_POST['email'];
	$sql = "SELECT * FROM EUSER WHERE USER_EMAIL = '$username'";
	$result = oci_parse($conn, $sql);
	oci_execute($result);

	$row = oci_fetch_array($result);

	$count = oci_num_rows($result);

	if($count == 1)
	{
		$newpass = mt_rand();
		
		$sql = "UPDATE EUSER SET USER_PASSWORD = '$newpass' WHERE USER_EMAIL = '$username'";
		$msg = "Please use this password to login: $newpass";

		// use wordwrap() if lines are longer than 70 characters
		$msg = wordwrap($msg,70);
		
				
		$headers = "From: nischalaryal11@gmail.com\r\n";
		$headers .= "Reply-To: ".$username."\r\n";
		// $headers .= "Return-Path: brontetbc@example.com\r\n";

		if ( mail($username,"Your Recovered Password",$msg,$headers) ) {
   			echo "Your reset password has been sent to your email id";
   		} 
		else 
		{
   			echo "Failed to recover your password, try again!";
   		}
			
	}
	else
	{
		echo "<script>alert('User does not exist in the database')</script>";
	}
	
	$updatepass = md5($newpass);
	$sql = "UPDATE EUSER SET USER_PASSWORD = '$updatepass' WHERE USER_EMAIL = '$username'";
		
	$result = oci_parse($conn, $sql);
	oci_execute($result);
	
	
	
}
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ShopHub | Recover password</title>
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
    <a href="index.php"><b>Bronte</b>End</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Enter your email to be recovered</p>

    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      	<div class="row">
        <div class="col-xs-8">
          </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
        </div>
        <!-- /.col -->
      </div>

    </form>

	<br>
    <a href="register.php" class="text-center">Register a new membership</a><br>
	<a href="login.php" class="text-center">Login</a>
        

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