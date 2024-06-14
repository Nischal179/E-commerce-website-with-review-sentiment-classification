<?php
include ('../core/connection.php');
include ('../includes/imageupload.php');	
	session_start();
	$txtPass="";
	if(isset($_SESSION['USER_ID'])){
		$USER_ID = $_SESSION['USER_ID'];
		$detail = "SELECT * FROM EUSER WHERE USER_ID = $USER_ID";
		$detailqry = oci_parse($conn, $detail);
		oci_execute($detailqry);
		while($row = oci_fetch_assoc($detailqry)){
			$txtFirstName = $row['USER_FIRST_NAME'];
			$txtLastName = $row['USER_LAST_NAME'];
			$txtAddress = $row['USER_ADDRESS'];
			$txtEmail = $row['USER_EMAIL'];
			$txtPass = $row['USER_PASSWORD'];		
		}
	}else{
		header('location:../login.php');
	}


$date = date('m-d-Y');
if (isset($_POST['save'])){
	$fname=$_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$pass = $_POST['pass'];
	$address = $_POST['address'];
	
	if($txtPass == $pass){
		$sql = "UPDATE EUSER SET USER_FIRST_NAME = '$fname', USER_LAST_NAME='$lname', USER_ADDRESS = '$address'  WHERE USER_ID = '$USER_ID'";
	}else{
		//$pass = md5($pass);
		$sql = "UPDATE EUSER SET USER_FIRST_NAME = '$fname', USER_LAST_NAME='$lname', USER_ADDRESS = '$address',USER_PASSWORD='$pass'  WHERE USER_ID = '$USER_ID'";
	}	
	
	$result = oci_parse($conn,$sql);
	oci_execute($result);
	if(!oci_error()){echo "<script>alert('You have sucessfully Edited Your Detail.');window.location.href='viewuser.php';</script>";}
	//header('location:viewuser.php');//redirect to view profie page
 
}
?>
<?php include('../includes/backend/head.php');?>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <?php include('./includes/nav.php'); ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">      

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Enter details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">                
				<div class="form-group">
                  <label for="exampleInpute">Email</label>
                  <input type="email" required class="form-control" id="exampleInpute" placeholder="Enter email" name="email" value="<?php echo $txtEmail?>">				 
                </div>
				<div class="form-group">
                  <label for="exampleInputFirstName">First Name</label>
                  <input type="text" required class="form-control" id="exampleInputFirstName" placeholder="Enter first name" name="fname" value="<?php echo $txtFirstName?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputLastName">Last Name</label>
                  <input type="text" required class="form-control" id="exampleInputLastName" placeholder="Enter last name" name="lname" value="<?php echo $txtLastName?>">
                </div>                
				<div class="form-group">
                  <label for="exampleInput">Password</label>
                  <input type="password" required class="form-control" id="exampleInput" placeholder="Enter Password" name="pass" value="<?php echo $txtPass?>">
                </div>
               	 <div class="form-group">
                  <label for="exampleInputAddress">Address</label>
                  <input type="text" class="form-control" id="exampleInputAddress" placeholder="Enter address" name="address" value="<?php echo $txtAddress?>">
                </div>
               </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="save" class="btn btn-primary">Save Changes</button>				
              </div>
            </form>
          </div>
      </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2023 <a href="">ShopHub</a>.</strong> All rights
    reserved.
  </footer>  

<!-- ./wrapper -->
<?php include('./includes/script.php'); ?>
</body>
</html>
