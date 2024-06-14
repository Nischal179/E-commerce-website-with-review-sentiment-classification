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
		  <div class="panel-heading">
			<h3 class="page-header p-b-md m-b-sm">
				SHOP CATEGORIES<br>
				
				<span class="pull-right">					
					<form method="get" action="addshopcat.php">
						<button type="submit" name="submit" class="btn btn-primary btn-block btn-flat">Add Shop Category</button>
					</form>					
				</span>
			</h3>
		</div>
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Shop Categories Table</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>                  
                  <th>Category Id</th>
				  <th>Category Name</th>
				  <th>Description</th>
				  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                	
					<?php
					$detail="SELECT * FROM SHOP_CATEGORY";
					$detailqry = oci_parse($conn, $detail);
					oci_execute($detailqry);
					while($row = oci_fetch_array($detailqry)){								
						?>
					<tr>
					  <td><?php echo $row['CATEGORY_ID'];?></td>
					  <td><?php echo $row['NAME'];?></td>
					  <td><?php echo $row['DESCRIPTION'];?></td>		  
					  <td class="text-center">							
							<a class="btn btn-default btn-sm" href="editshopcat.php?sid=<?php echo $row['CATEGORY_ID']; ?>">
								<i class="fa fa-pencil"></i>                
							</a>							
							<a class="btn btn-default btn-sm" href="deleteshopcat.php?sid=<?php echo $row['CATEGORY_ID']; ?>">
								<i class="fa fa-trash-o"></i>                
							</a>
						</td>
					
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
