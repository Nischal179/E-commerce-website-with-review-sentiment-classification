<?php
	session_start();
	if(isset($_SESSION['USER_ID'])){
		$USER_ID = $_SESSION['USER_ID'];	
	}else{
		header('location:../login.php');
	}
	include ('../core/connection.php');
	include ('imageupload.php');

	$trader_id = $USER_ID;
	
	$isUsed = false;
	$shopCatId = $txtName = $txtMan = $txtNoSt = $txtPh1 = $txtPh2 = $txtReg = $txtMail = "";
	$isRegistered = 0;
	$sql="SELECT * FROM TRADERS WHERE USER_ID='$USER_ID' AND PROFILE_COMPLETE='1'";
	$qry = oci_parse($conn, $sql);
	oci_execute($qry);
	while($row = oci_fetch_array($qry)){
		$isRegistered = 1;
	}
	
	if($isRegistered == 0){
		echo "<script>alert('Please Complete your profile first to add a shop.');window.location.href='edituser.php';</script>";
	}
if (isset($_POST['addprod'])){	
	$shopCatId = $_POST["shopCatId"];
	$txtName = $_POST["txtName"];
	$txtMan = $_POST["txtMan"];
	$txtNoSt = $_POST["txtNoSt"];
	$txtPh1 = $_POST["txtPh1"];	
	$txtPh2 = $_POST["txtPh2"];	
	$txtReg = $_POST["txtReg"];
	$txtMail = $_POST["txtMail"];
	
	$error_count = 0;
	$txtCapName = strtoupper($txtName);
	$detail="SELECT * FROM SHOP WHERE UPPER(NAME)='$txtCapName'";
	$detailqry = oci_parse($conn, $detail);
	oci_execute($detailqry);
	while($row = oci_fetch_array($detailqry)){
		$error_count++;
	}
	if($error_count!=0){
		$isUsed = true;
		echo "<script>alert('Shop Name Already Taken. Please Enter New Shop Name');</script>";
	}else{	
		//if there are no errors save it to database
		if ($error_count == 0){
			$sql = "INSERT INTO SHOP (SHOP_ID, TRADER_ID, SHOP_CATEGORY_ID, NAME, MANAGER, NUM_OF_STAFF, PHONE_LINE_1, PHONE_LINE_2, REG_NUM, MAILING_ADDR) VALUES 
			(seq_shops.nextval, '$trader_id','$shopCatId','$txtName', '$txtMan', '$txtNoSt', '$txtPh1', '$txtPh2', '$txtReg', '$txtMail')";			
			$result = oci_parse($conn,$sql);		
			oci_execute($result);		
			echo "<script>alert('You have sucessfully Added a new Shop.');window.location.href='myshop.php';</script>";
		} 
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
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       	Add Shop
      </h1>
      <ol class="breadcrumb">
        <li><a href="../../../index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Shop</li>
      </ol>
    </section>

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
						<label class="col-md-3">Shop Category</label>
						<div class="col-md-9">							
							<select required class="form-control" name="shopCatId">
								
								<?php
									$sql2 = "SELECT * FROM SHOP_CATEGORY";
									$result2 = oci_parse($conn,$sql2);
									oci_execute($result2);									
									while ($row = oci_fetch_assoc($result2)){									
										?>
										<option <?php if($shopCatId==$row['CATEGORY_ID']){echo "selected";}?> value="<?php echo $row['CATEGORY_ID']; ?>">
											<?php echo $row['NAME']; ?>
										</option>
										<?php
									}
								?>
							</select>							
						</div>
					</div>
					<br><br>
				
                <div class="form-group">
                  <label for="exampleInputDescription">Shop Name</label>
                  <input type="text" required class="form-control" id="name" placeholder="Name of your shop ..." name="txtName" value = "<?php if($txtName!="" AND $isUsed==false){echo $txtName;}?>">
                </div>
               	<div class="form-group">
                  <label for="exampleInputPrice">Manager</label>
                  <input type="text" required class="form-control" id="man" placeholder="Manager of the shop ... " name="txtMan" value = "<?php if($txtMan!=""){echo $txtMan;}?>">
                </div>
				<div class="form-group">
                  <label for="exampleInputQuantity">Number of Staffs</label>
                  <input type="number" required class="form-control" id="nos" placeholder="Total number of staffs working on a shop ... " name="txtNoSt" value = "<?php if($txtNoSt!=""){echo $txtNoSt;}?>">
                </div>
               	<div class="form-group">
                  <label for="exampleInputAllergy">Phone Line 1</label>
                  <input type="text" required class="form-control" id="l1" placeholder="Phone Line 1 ..." name="txtPh1" value = "<?php if($txtPh1!=""){echo $txtPh1;}?>">
                </div>
				<div class="form-group">
                  <label for="exampleInputPrice">Phone Line 2</label>
                  <input type="text" class="form-control" id="l2" placeholder="Phone Line 2 ... " name="txtPh2" value = "<?php if($txtPh2!=""){echo $txtPh2;}?>">
                </div>
				<div class="form-group">
                  <label for="exampleInputPrice">Shop Registration Number</label>
                  <input type="text" required class="form-control" id="reg" placeholder="Registration Number of Shop ..." name="txtReg" value = "<?php if($txtReg!=""){echo $txtReg;}?>">
                </div>
				<div class="form-group">
                  <label for="exampleInputPrice">Mailing Address</label>
                  <input type="email" required class="form-control" id="mail" placeholder="Mailing Address" name="txtMail" value = "<?php if($txtMail!=""){echo $txtMail;}?>">
                </div>                
               </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="addprod" class="btn btn-primary">Add Shop</button>
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
<?php include('includes/script.php'); ?>
</body>
</html>
