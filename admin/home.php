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
    <!-- Content Header (Page header) -->    
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="panel panel-card">
            <div class="panel-heading">
                <h3 class="page-header p-b-md">Dashboard - Super Admin Home</h3>
            </div>
            <div class="panel-body outer-body">
                <div class="row">
					<div class="col-lg-4 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-briefcase fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
											<?php										
												$trader_count =0;
												$detail="SELECT * FROM EUSER WHERE UPPER(USER_TYPE)='TRADER'";
												$detailqry = oci_parse($conn, $detail);
												oci_execute($detailqry);
												while($row = oci_fetch_array($detailqry)){
													$trader_count++;
												}
											?>
                                            <div class="huge"><font size="20"><?php echo $trader_count;?></font></div>
                                        </div>
                                        <div>Total Traders</div>
                                    </div>
                                </div>
                            </div>
                            <a href="managetraders.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
					
					<div class="col-lg-4 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-home fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
											<?php										
												$SHOP_COUNT =0;
												$detail="SELECT * FROM SHOP";
												$detailqry = oci_parse($conn, $detail);
												oci_execute($detailqry);
												while($row = oci_fetch_array($detailqry)){
													$SHOP_COUNT++;
												}
											?>
                                            <div class="huge"><font size="20"><?php echo $SHOP_COUNT; ?></font></div>
                                        </div>
                                        <div>Total Shops</div>
                                    </div>
                                </div>
                            </div>
                            <a href="manageshop.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
					
					<div class="col-lg-4 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-home fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
											<?php										
												$PRODUCT_COUNT =0;
												$detail="SELECT * FROM PRODUCT";
												$detailqry = oci_parse($conn, $detail);
												oci_execute($detailqry);
												while($row = oci_fetch_array($detailqry)){
													$PRODUCT_COUNT++;
												}
											?>
                                            <div class="huge"><font size="20"><?php echo $PRODUCT_COUNT; ?></font></div>
                                        </div>
                                        <div>Total Products</div>
                                    </div>
                                </div>
                            </div>
							<a>
                                <div class="panel-footer">
                                    <span class="pull-left"></span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>                            
                        </div>
                    </div>
					
					<div class="col-lg-4 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-briefcase fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
											<?php										
												$user_count =0;
												$detail="SELECT * FROM EUSER WHERE UPPER(USER_TYPE)='CUSTOMER'";
												$detailqry = oci_parse($conn, $detail);
												oci_execute($detailqry);
												while($row = oci_fetch_array($detailqry)){
													$user_count++;
												}
											?>
                                            <div class="huge"><font size="20"><?php echo $user_count;?></font></div>
                                        </div>
                                        <div>Total Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="manageusers.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
					
                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list-alt fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
											<?php										
												$SHOP_CAT_COUNT =0;
												$detail="SELECT * FROM SHOP_CATEGORY";
												$detailqry = oci_parse($conn, $detail);
												oci_execute($detailqry);
												while($row = oci_fetch_array($detailqry)){
													$SHOP_CAT_COUNT++;
												}
											?>
											<div class="huge"><font size="20"><?php echo $SHOP_CAT_COUNT;?></font></div>
                                        </div>
                                        <div>Shop Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="shopcatagories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-shopping-cart fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
										<?php										
											$product_categories_count =0;
											$detail="SELECT * FROM PRODUCT_CATEGORY";
											$detailqry = oci_parse($conn, $detail);
											oci_execute($detailqry);
											while($row = oci_fetch_array($detailqry)){
												$product_categories_count++;
											}
										?>
                                        <div class="huge"><font size="20"><?php echo $product_categories_count; ?></font></div>
                                        <div>Product Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="productcatagories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                </div>                
            </div>
			<div class="row">
                    <div id="barchart_values" style="width: 900px; height: 300px;"></div>
                </div>
        </div>
    </div>
</div>
</div>
<?php include('includes/script.php'); ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 <script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Trader", "Shop Count", { role: "style" } ],
        <?php
        while ($row=oci_fetch_assoc($result)) {
            ?>
            <?php echo "['" . $row['TRADER_NAME'] . "'," . $row['SHOP_COUNT'] . ", 'gold']," ?>
            <?php
        }
        ?>
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Trader and their shops!",
        width: 1000,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
      chart.draw(view, options);
  }
  </script>