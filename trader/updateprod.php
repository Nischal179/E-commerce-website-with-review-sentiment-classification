 <?php
	session_start();
	if(isset($_SESSION['USER_ID'])){
		$USER_ID = $_SESSION['USER_ID'];	
	}else{
		header('location:../login.php');
	}
	include ('imageupload.php');
	include ('../core/connection.php');
	$trader_id = $USER_ID;
	
	if(isset($_GET['id'])){
    	$eid = $_GET['id'];
		$details = "DELETE FROM product WHERE product_id = '$eid'";
   		$detailqry = oci_parse($conn, $details);
		oci_execute($detailqry); 
		header("location:updateprod.php");	
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
        Products
      </h1>
      <ol class="breadcrumb">
        <li><a href="../../index.php"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Update/Delete Product</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">        
		<?php
			$detail1="SELECT * FROM SHOP WHERE TRADER_ID=$trader_id";
			$detailqry1 = oci_parse($conn, $detail1);
			oci_execute($detailqry1);
			while($row1 = oci_fetch_array($detailqry1)){
				$SHOP_ID = $row1['SHOP_ID'];
				?>
				<?php
				$detail="SELECT * FROM PRODUCT WHERE PRODUCT_SHOP_ID=$SHOP_ID";
				$detailqry = oci_parse($conn, $detail);
				oci_execute($detailqry);
				while($row = oci_fetch_array($detailqry)){
					$url = "../".$row['PRODUCT_IMAGE_PATH'];
					$id = $row['PRODUCT_ID'];
					?>

        <div class="col-md-3">
		 
			
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
            
              <img style="height:150px; width:100px;" class="profile-user-img img-responsive img-circle" src="<?php echo $url;?>" alt="No Image Found">

              <h3 class="profile-username text-center"><?php echo $row['PRODUCT_NAME']; ?></h3>

              
              <?php echo "<a class='btn btn-primary btn-block' href='alterprod.php?id=".$id."'"?><b>Update</b></a>
              <?php echo "<a class='btn btn-primary btn-block' href='?id=".$id."'"?><b>Delete</b></a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
	</div>
        <?php } ?>
	<?php } ?>
    </div>
    </section>
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
