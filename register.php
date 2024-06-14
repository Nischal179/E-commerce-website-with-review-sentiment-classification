<?php
	
	session_start();
	
	
	include 'core/connection.php';
	$isRegistered = false;
	$fname = $lname = $address = $email = $pass = $repass = $user_type = "";
	$rowCount=0;
	if(isset($_POST['submit'])){
		$fname =$_POST['fname'];
		$lname = $_POST['lname'];
		$address = $_POST['address'];
		$email = $_POST['email'];
		$pass = $_POST['pass'];
		$repass = $_POST['repass'];
		$user_type = $_POST['user_type'];
		
		date_default_timezone_set('Asia/Kathmandu');		
		$date = date("Y-m-d h:i:sA");
		
		$detail="SELECT * FROM EUSER WHERE USER_EMAIL='$email'";
		$detailqry = oci_parse($conn, $detail);
		oci_execute($detailqry);
		while($row = oci_fetch_array($detailqry)){
			$rowCount++;
		}
		if($rowCount==0){
			if($repass == $pass){
				$pass = $pass;
				if(strtoupper($user_type) == 'CUSTOMER'){			
				
				$sql = "INSERT INTO euser(user_id, user_first_name, user_last_name, user_address, user_email, user_password, user_type, active, USER_CREATED_AT) VALUES 
					(seq_users.nextval, '$fname','$lname','$address', '$email', '$pass', '$user_type', '1', '$date')";
						
				$result = oci_parse($conn,$sql);			
				oci_execute($result);
					if(oci_error()){
						echo "<script>alert('Oci Error');</script>";
					}
          else{
						$_SESSION['fname'] =$_POST['fname'];
						$_SESSION['lname'] = $_POST['lname'];
						$_SESSION['address'] = $_POST['address'];
						$_SESSION['email'] = $_POST['email'];
						$_SESSION['pass'] = $_POST['pass'];
						$_SESSION['repass'] = $_POST['repass'];
						header('Location: login.php');
				  }
				}
        else if(strtoupper($user_type) == 'TRADER')
        {
          $_SESSION['fname'] =$_POST['fname'];
          $_SESSION['lname'] = $_POST['lname'];
          $_SESSION['address'] = $_POST['address'];
          $_SESSION['email'] = $_POST['email'];
          $_SESSION['pass'] = $_POST['pass'];
          $_SESSION['repass'] = $_POST['repass'];
          header('Location: regtrader.php');
        }
        
        
			}else{
				if($repass != ""){				
					echo "<script>alert('Your confirm Password does not match');</script>";
				}			
			}
		}else{
			$isRegistered = true;
			echo "<script>alert('User Already Registered. Please Enter new id');</script>";
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
    <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../assets/bootstrap/dist/css/bootstrap.min.css">
</head>

	<!-- /top Header -->
	<div class="container" id="logo">
		<div class="container">
			<div class="pull-left">
				<!-- Logo -->
				<!-- <div class="header-logo">
					<a class="logo" href="index.php">
						<img src="misc/img/logo.png" alt="">
					</a>
				</div> -->
				<!-- /Logo -->				
			</div>
		</div>
	</div>
	
<body class="hold-transition">
<style>
#register {
    border: 0px solid;
    padding: 10px;
    box-shadow: 0 0 5px #888888;
	background-color: #ffffff;
}
#logo {
	width: 100%;
	background-color: #ffffff;
}

body{
    background-color: #f9f9f9;
}
</style>
<div class="register-box" id="register">
  <div class="register-logo">
    <a href="index.php"><span style="color: #C0282E">Shop</span><b>Hub</b></a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Register a new membership</p>

    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="text" required class="form-control" name="fname" placeholder="First name" value = "<?php if($fname!=""){echo $fname;}?>">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" required class="form-control" name="lname" placeholder="Last name" value = "<?php if($lname!=""){echo $lname;}?>">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="address" placeholder="Address" value = "<?php if($address!=""){echo $address;}?>">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      
      
      <div class="form-group has-feedback">
        <input type="email" required class="form-control" name="email" placeholder="Email" value = "<?php if($email!="" AND $isRegistered==false){echo $email;}?>">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" required class="form-control" name="pass" placeholder="Password" value = "<?php if($pass!=""){echo $pass;}?>">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" required class="form-control" name="repass" placeholder="Retype password">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
      <label for="exampleInputType">Register as</label>
        <select required id="exampleInputType" class="form-control" name="user_type">
                  	<option <?php if($user_type=="Customer"){echo "selected";}?>>Customer</option>
                    <option <?php if($user_type=="Trader"){echo "selected";}?>>Trader</option>
                    </select>
                
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox">
            <label>
              <input required type="checkbox"> I agree to the terms</input>
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat">Register</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

   

    <a href="login.php" class="text-center">I already have a membership</a>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 3 -->
<script src="assets/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="assets/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="assets/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
