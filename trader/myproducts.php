<?php
session_start();
if(isset($_SESSION['USER_ID'])){
	$USER_ID = $_SESSION['USER_ID'];	
}else{
	header('location:../login.php');
}
include ('../core/connection.php');
$trader_id = $USER_ID;
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
        Data Tables
        <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">User Data Table</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Product ID</th>
                  <th>Product Name</th>
                  <th>Product Description</th>                  
                  <th>Product Price</th>
                  <th>Product Quantity</th>             
                </tr>
                </thead>
                <tbody>
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
								?>
							<tr>
							  <td><?php echo $row['PRODUCT_ID'];?></td>
							  <td><?php echo $row['PRODUCT_NAME'];?></td>
							  <td><?php echo $row['PRODUCT_DESCRIPTION'];?></td>						  
							  <td><?php echo $row['PRODUCT_PRICE'];?></td>
							  <td><?php echo $row['PRODUCT_QUANTITY'];?></td>			  
							
							</tr>
						<?php }?>
					<?php }?>
                </tbody>
                
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

         
          <!-- /.box -->


        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
   <strong>Copyright &copy; 2023 <a href="">ShopHub</a>.</strong> All rights
    reserved.
  </footer>  

<!-- ./wrapper -->
<?php include('./includes/script.php'); ?>
</body>
</html>
