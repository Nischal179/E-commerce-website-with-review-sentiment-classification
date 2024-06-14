<?php
	session_start();
	if(isset($_SESSION['USER_ID'])){
	$USER_ID = $_SESSION['USER_ID'];	
	}else{
		header('location:../login.php');
	}
include '../core/connection.php';
if(isset($_GET['sid'])){
	$error_count=0;
	$sid = $_GET['sid'];
	$detail = "SELECT * FROM SHOP_CATEGORY WHERE CATEGORY_ID = $sid";
	$detailqry = oci_parse($conn, $detail);
	oci_execute($detailqry);
	while($row = oci_fetch_assoc($detailqry)){
		$txtName = $row['NAME'];
		$txtDesc = $row['DESCRIPTION'];
				
	}
}
if(isset($_POST['updateprod'])){
	$error_count=0;
	If(!empty($_POST["pname"])){
	$pname = $_POST["pname"];
		
	}else{
		$error_count++;
	}
	
	If(!empty($_POST["pdesc"])){
	$pdesc = $_POST["pdesc"];
		
	}else{
		$error_count++;
	}
	if ($error_count == 0){
		$detail = "UPDATE SHOP_CATEGORY SET NAME = '$pname', DESCRIPTION='$pdesc' WHERE CATEGORY_ID = $sid";
		$detailqry = oci_parse($conn, $detail);		
		oci_execute($detailqry);
		echo "<script>alert('You have sucessfully Edited a Shop Category.');window.location.href='shopcatagories.php';</script>";
		
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
       	Update Shop Category
      </h1>
      <ol class="breadcrumb">
        <li><a href="../../../index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Update Shop Category</li>
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
				  <div class="form-group has-feedback">
					<label>Title</label>
					<input type="text" required class="form-control" placeholder="Category Name" value="<?php echo $txtName?>" name="pname">
					<span class="form-control-feedback"></span>
				  </div>
				  <div class="form-group has-feedback">
					<label>Description</label>
					<input type="text" required class="form-control" placeholder="Description" value="<?php echo $txtDesc?>" name="pdesc">
					<span class="form-control-feedback"></span>
				  </div>			  

               </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="updateprod" class="btn btn-primary">Update Shop Category</button>
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
