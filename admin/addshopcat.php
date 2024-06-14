<?php
	session_start();
if(isset($_SESSION['USER_ID'])){
	$USER_ID = $_SESSION['USER_ID'];	
}else{
	header('location:../login.php');
}
include '../core/connection.php';
if(isset($_POST['submit'])){	
	$pname = $_POST["pname"];
	$pdesc = $_POST["pdesc"];		
	$detail = "INSERT INTO SHOP_CATEGORY VALUES(seq_shop_category.nextval,'$pname','$pdesc')";
	$detailqry = oci_parse($conn, $detail);		
	oci_execute($detailqry);
	echo "<script>alert('You have sucessfully Added a Shop Category.');window.location.href='shopcatagories.php';</script>";			
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
       	Add Shop Category
      </h1>
      <ol class="breadcrumb">
        <li><a href="../../../index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Shop Category</li>
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
					<input type="text" required class="form-control" placeholder="Category Name" name="pname">
					<span class="form-control-feedback"></span>
				  </div>
				  <div class="form-group has-feedback">
					<label>Description</label>
					<input type="text" required class="form-control" placeholder="Description" name="pdesc">
					<span class="form-control-feedback"></span>
				  </div>			  

               </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="submit" class="btn btn-primary">Add Shop Category</button>
              </div>
            </form>
          </div>
      </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2023 <a href="">ShopHubs</a>.</strong> All rights
    reserved.
  </footer>

<!-- ./wrapper -->
<?php include('./includes/script.php'); ?>
</body>
</html>
