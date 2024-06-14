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
              <h3 class="box-title">Shop Table</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>                  
                  <th>Shop Name</th>
				  <th>Manager</th>
				  <th>No Of Staff</th>
				  <th>Phone 1</th>
				  <th>Phone 2</th>
				  <th>Reg No</th>
				  <th>Mailing Address</th>
                </tr>
                </thead>
                <tbody>
                	
					<?php
					$detail="SELECT * FROM SHOP WHERE TRADER_ID=$trader_id";
					$detailqry = oci_parse($conn, $detail);
					oci_execute($detailqry);
					while($row = oci_fetch_array($detailqry)){								
						?>
					<tr>
					  <td><?php echo $row['NAME'];?></td>
					  <td><?php echo $row['MANAGER'];?></td>
					  <td><?php echo $row['NUM_OF_STAFF'];?></td>						  
					  <td><?php echo $row['PHONE_LINE_1'];?></td>
					  <td><?php echo $row['PHONE_LINE_2'];?></td>
					  <td><?php echo $row['REG_NUM'];?></td>
					  <td><?php echo $row['MAILING_ADDR'];?></td>			  
					
					</tr>
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
    <strong>Copyright &copy; 2023 <a href="">ShopHub</a>.</strong> All rights
    reserved.
  </footer>  

<!-- ./wrapper -->
<?php include('./includes/script.php'); ?>
</body>
</html>
