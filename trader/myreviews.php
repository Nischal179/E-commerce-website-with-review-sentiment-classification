<?php
	session_start();
	if(isset($_SESSION['USER_ID'])){
	$USER_ID = $_SESSION['USER_ID'];	
	}else{
		header('location:../login.php');
	}
include ('../core/connection.php');
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
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">My Reviews</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>                  
                  <th>Review Id</th>
                  <th>Customer Id</th>
                  <th>Product Name</th>
                  <th>Shop Name</th>
                  <th>Product Rating</th>
                  <th>Product Review</th>
                  <th>Customer Sentiment</th>
                </tr>
                </thead>
                <tbody>
                	
					<?php
					$detail="SELECT * FROM REVIEW re, PRODUCT prod,  SHOP sp  WHERE re.PRODUCT_ID=prod.PRODUCT_ID AND prod.PRODUCT_SHOP_ID=sp.SHOP_ID AND TRADER_ID = '$USER_ID'";
					$detailqry = oci_parse($conn, $detail);
					oci_execute($detailqry);
					while($row = oci_fetch_array($detailqry)){
					?>
						<tr>
						  <td><?php echo $row['REVIEW_ID'];?></td>
						  <td><?php echo $row['USER_ID'];?></td>						  
						  <td><?php echo $row['PRODUCT_NAME'];?></td>
						  <td><?php echo $row['NAME'];?></td>
						  <td><?php echo $row['REVIEW_RATING'];?></td>
						  <td><?php echo $row['REVIEW_DESCRIPTION'];?></td>
              <?php 
                if(strcasecmp(trim($row['SENTIMENT']),"Positive")==0)
                {
                  echo '<td>';
                  echo "<font color='#8ed100'><b>Positive</b></font>";
                  echo '<td>';
                }
                else
                {
                  echo '<td>';
                  echo "<font color='#750000'><b>Negative</b></font>";
                  echo "</td>";
                }
							?>
						<!-- <?php
									if($row['IS_DELIVERED']==1){
										//echo '<td bgcolor="#8ed100">';
										echo '<td>';
										echo "<font color='#8ed100'><b>DELIVERED</b></font>";
										$buttonText = "NOT DELIVERED";
									}else{
										echo '<td>';
										echo "<font color='#750000'><b>NOT DELIVERED</b></font>";
										$buttonText = "DELIVERED";
									}
									echo "</td>";
								?>	 -->
							
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
