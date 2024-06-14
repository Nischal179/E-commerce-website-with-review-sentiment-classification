<?php
	session_start();
	if(isset($_SESSION['USER_ID'])){
		$USER_ID = $_SESSION['USER_ID'];	
	}else{
		header('location:../login.php');
	}
include ('../core/connection.php');
include ('../includes/imageupload.php');
	
	$fname = "N/A";
	$lname = "N/A";
	$email = "N/A";
	$address = "N/A";
	$created = "N/A";				

	$sql = "SELECT * FROM  EUSER WHERE USER_ID= '$USER_ID'";
	
	$result = oci_parse($conn,$sql);
	
	oci_execute($result);		

	while($row = oci_fetch_assoc($result))
	{
		$userid = $row['USER_ID'];
		$fname = $row['USER_FIRST_NAME'];
		$lname = $row['USER_LAST_NAME'];
		$email = $row['USER_EMAIL'];
		$address = $row['USER_ADDRESS'];
		$created = $row['USER_CREATED_AT'];
		
		if($fname == "")
		{
			$fname = "Not Available";
		}
		if($lname == "")
		{
			$lname = "Not Available";
		}
		if($email == "")
		{
			$email = "Not Available";
		}
		if($address == "")
		{
			$address = "Not Available";	
		}
		if($created == "")
		{
			$created = "Not Available";
		}
		
	}



?>

<!DOCTYPE html>
<?php include('../includes/backend/head.php');?>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <?php include('./includes/nav.php'); ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       	View Profile
      </h1>
      <ol class="breadcrumb">
        <li><a href="../index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">View Profile</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          
          
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow">
              <div class="widget-user-image">
                <img class="img-circle" src="../assets/dist/img/avatar04.png" alt="User Avatar">
                
              </div>
              
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?php echo $fname." ".$lname?></h3>
              
              <h5 class="widget-user-desc">ADMIN</h5>
              
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href=""><?php echo $email?><span class="pull-right badge bg-aqua">Email</span></a></li>
                <li><a href=""><?php echo $address?><span class="pull-right badge bg-green">Address</span></a></li>				
                <li><a href=""><?php echo $created?> <span class="pull-right badge bg-red">Created at</span></a></li>
                
              </ul>
            </div>
          </div>
          <a href="edituser.php" class="btn btn-app">
                <i class="fa fa-edit"></i> Edit
              </a>
              
          </div>
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
