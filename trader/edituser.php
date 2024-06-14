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
			$txtPass = $row['USER_PASSWORD'];			
		}
		$hasTraderInfo = false;
		$tname = $tpan = $tbank = $tmail = $tss = $thead = $tacc = "";
		$detail = "SELECT * FROM TRADERS WHERE USER_ID = $USER_ID";
		$detailqry = oci_parse($conn, $detail);
		oci_execute($detailqry);
		while($row = oci_fetch_assoc($detailqry)){
			$hasTraderInfo = true;
			$tname = $row['NAME'];
			$tpan = $row['PAN_NUMBER'];
			$tbank = $row['BANK'];			
			$tmail = $row['MAILING_ADDR'];
			$tss = $row['SOCIAL_SECURITY'];
			$thead = $row['TRADER_HEAD'];
			$tacc = $row['BANK_ACC_NUM'];			
		}
		
	}else{
		header('location:../login.php');
	}


$date = date('m-d-Y');
if (isset($_POST['save'])){
	$fname=$_POST['fname'];
	$lname = $_POST['lname'];	
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

if (isset($_POST['save2'])){
	$tname=$_POST['tname'];
	$tpan = $_POST['tpan'];	
	$tbank = $_POST['tbank'];
	$tmail = $_POST['tmail'];
	$tss=$_POST['tss'];		
	$thead = $_POST['thead'];
	$tacc = $_POST['tacc'];
	
	if($hasTraderInfo){
		//save changes
		$sql1 = "UPDATE TRADERS SET NAME = '$tname', PAN_NUMBER='$tpan', BANK='$tbank', MAILING_ADDR='$tmail', SOCIAL_SECURITY='$tss', TRADER_HEAD='$thead',
		BANK_ACC_NUM='$tacc' WHERE USER_ID = '$USER_ID'";
		$result1 = oci_parse($conn,$sql1);
		oci_execute($result1);
		if(!oci_error()){echo "<script>alert('You have sucessfully Edited Your Trader Detail.');window.location.href='viewuser.php';</script>";}
	}else{
		//save new details		
		$sql = "INSERT INTO TRADERS (TRADER_ID, USER_ID, NAME, PAN_NUMBER, BANK, MAILING_ADDR, SOCIAL_SECURITY, TRADER_HEAD, PROFILE_COMPLETE, BANK_ACC_NUM) 
		VALUES(seq_trader.nextval,'$USER_ID','$tname','$tpan','$tbank','$tmail','$tss','$thead','1','$tacc')";
		$result = oci_parse($conn,$sql);
		oci_execute($result);
		if(!oci_error()){echo "<script>alert('You have sucessfully Added Your Trader Detail.');window.location.href='viewuser.php';</script>";}
		}

 
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
              <h3 class="box-title"><b>Enter Personal Details<b></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputFirstName">First Name</label>
                  <input type="text" required class="form-control" id="exampleInputFirstName" placeholder="Enter first name" name="fname" value="<?php echo $txtFirstName?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputLastName">Last Name</label>
                  <input type="text" required class="form-control" id="exampleInputLastName" placeholder="Enter last name" name="lname" value="<?php echo $txtLastName?>">
                </div>                
				<div class="form-group">
                  <label for="exampleInputEmail">Password</label>
                  <input type="password" required class="form-control" id="exampleInputEmail" placeholder="Enter email" name="pass" value="<?php echo $txtPass?>">
                </div>
               	 <div class="form-group">
                  <label for="exampleInputAddress">Address</label>
                  <input type="text" required class="form-control" id="exampleInputAddress" placeholder="Enter address" name="address" value="<?php echo $txtAddress?>">
                </div>
               </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="save" class="btn btn-primary">Save Changes</button>
              </div>
			  
            </form>
          </div>
      </section>
	  
	      <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><b>Enter Trader Details</b></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputFirstName">Name</label>
                  <input type="text" required class="form-control" id="exampleInputFirstName" placeholder="Enter Name" name="tname" value="<?php echo $tname?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputLastName">PAN / VAT NUMBER</label>
                  <input type="number" required class="form-control" id="exampleInputLastName" placeholder="Enter Pan / Vat Number" name="tpan" value="<?php echo $tpan?>">
                </div>                
				<div class="form-group">
                  <label for="exampleInputEmail">BANK</label>
                  <input type="text" required class="form-control" id="exampleInputEmail" placeholder="Enter Bank Name" name="tbank" value="<?php echo $tbank?>">
                </div>
				<div class="form-group">
                  <label for="exampleInputAddress">BANK ACCOUNT NUM</label>
                  <input type="text" required class="form-control" id="exampleInputAddress" placeholder="Enter Bank Account Number" name="tacc" value="<?php echo $tacc?>">
                </div>
               	 <div class="form-group">
                  <label for="exampleInputAddress">MAILING ADDR</label>
                  <input type="Email" required class="form-control" id="exampleInputAddress" placeholder="Enter Email address" name="tmail" value="<?php echo $tmail?>">
                </div>
				<div class="form-group">
                  <label for="exampleInputAddress">SOCIAL SECURITY</label>
                  <input type="text" required class="form-control" id="exampleInputAddress" placeholder="Enter Social Security Number" name="tss" value="<?php echo $tss?>">
                </div>
				<div class="form-group">
                  <label for="exampleInputAddress">TRADER HEAD</label>
                  <input type="text" required class="form-control" id="exampleInputAddress" placeholder="Enter Trader Head" name="thead" value="<?php echo $thead?>">
                </div>				
               </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="save2" class="btn btn-primary">Save Changes</button>
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
