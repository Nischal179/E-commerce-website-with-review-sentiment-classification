<?php
include ('../core/connection.php');
include ('../includes/imageupload.php');
include('functions.php');

$totalprice = 0;

session_start();

$date = date('m-d-Y');

if(isset($_SESSION['USER_ID']))
{
	$user_id = $_SESSION['USER_ID'];	
}
else
{
	header('location:../login.php');
}

if (isset($_POST['save'])) 
{
	$fname=$_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$address = $_POST['address'];
	
	//ensure that form filled are filled properly

	
	
		
		$sql = "UPDATE EUSER SET USER_FIRST_NAME = '$fname', USER_LAST_NAME='$lname', USER_ADDRESS = '$address', USER_EMAIL='$email', USER_UPDATED_AT = TO_DATE('$date', 'MM/DD/YY') WHERE USER_EMAIL = '$user_id'";
		
		$result = oci_parse($conn,$sql);
		
		oci_execute($result);		

	header('location:viewuser.php');//redirect to view profie page
 
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
      <ol class="breadcrumb">
        <li><a href="../index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Cart details</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-9">
          <!-- general form elements -->
          <div class="box box-primary">
            
            <!-- /.box-header -->
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">Cart Details</h3>

              <div class="box-tools">
                
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Quantity</th>
                  <th>Discount</th>
                  <th>Price</th>
                  <th>Total Price</th>
                </tr>
                
                                               <?php
									$ip_add = getRealUserIp();
    	                            $sql = "SELECT * FROM cart WHERE ip_add = '$ip_add'";
	                                $query = oci_parse($conn, $sql);

	                                oci_execute($query);
	
    	                            while ($row = oci_fetch_assoc($query)) {
                                    ?>

                                    
                                    <tr>
                                    
                                    <?php
											$pid = $row['P_ID'];
											$sql1 = "SELECT * FROM product WHERE PRODUCT_ID = '$pid'";
											$result = oci_parse($conn, $sql1);
											oci_execute($result);
											$row2 = oci_fetch_array($result);
											$total = $row['P_PRICE']*$row['QTY'];
											$totalafterdis = $total - (($row2['PRODUCT_DISCOUNT_PERCENT']/100)*$total);
											$totalprice += $totalafterdis;
											?>

                <tr>
                  <td><?php echo $pid?></td>
                  <td><?php echo $row2['PRODUCT_NAME']?></td>
                  <td><?php echo $row2['PRODUCT_DESCRIPTION']?></td>
                  <td><?php echo $row['QTY']?></td>
                  <td><span class="label label-success"><?php if($row2['PRODUCT_DISCOUNT_PERCENT']==""){echo 0;}else{echo $row2['PRODUCT_DISCOUNT_PERCENT'];}?> %</span></td>
                  <td><?php echo $row['P_PRICE']?></td>
                  <td><?php echo $totalafterdis?></td>
                </tr>
                									 <?php } ?>

                 </table>
            </div>
            <!-- /.box-body -->
          </div>
            <!-- form start -->
            
           </div>
  		    <a href="../checkout.php"><button class="btn btn-primary">Checkout</button></a> 
      </section>
    <!-- /.content -->
  
  </div>
  
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2023 <a href="">ShopHub</a>.</strong> All rights
    reserved.
  </footer>


<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>


<!-- ./wrapper -->
<?php include('./includes/script.php'); ?>
</body>
</html>
