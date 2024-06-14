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
            <div class="panel-heading p-h-md">
                <h3 class="page-header p-b-md">Trader's Dashboard</h3>
            </div>
            <div class="panel-body">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-building-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
									<?php										
										$SHOP_COUNT =0;
										$detail="SELECT * FROM SHOP WHERE TRADER_ID=$trader_id";
										$detailqry = oci_parse($conn, $detail);
										oci_execute($detailqry);
										while($row = oci_fetch_array($detailqry)){
											$SHOP_COUNT++;
										}
									?>
                                    <div class="huge"><font size="20"><?php echo $SHOP_COUNT; ?></font></div>
                                    <div>Your shops!</div>
                                </div>
                            </div>
                        </div>
                        <a href="myshop.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
									<?php
										$outOfStockCount = 0;
										$detail="SELECT * FROM SHOP WHERE TRADER_ID=$trader_id";
										$detailqry = oci_parse($conn, $detail);
										oci_execute($detailqry);
										while($row = oci_fetch_array($detailqry)){
											$sid = $row['SHOP_ID'];
											$sql="SELECT * FROM PRODUCT WHERE PRODUCT_SHOP_ID=$sid AND PRODUCT_QUANTITY<='0'";
											$qry = oci_parse($conn, $sql);
											oci_execute($qry);
											while(oci_fetch_array($qry)){
												$outOfStockCount ++;
											}
											
										}
									?>
                                    <div class="huge"><font size="20"><?php echo $outOfStockCount; ?></font></div>
                                    <div>Out of Stock!</div>
                                </div>
                            </div>
                        </div>
                        <a href="myproducts.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
                                        $review_count = 0;
										$detail="SELECT * FROM REVIEW re, PRODUCT prod,  SHOP sp  WHERE re.PRODUCT_ID=prod.PRODUCT_ID AND prod.PRODUCT_SHOP_ID=sp.SHOP_ID AND TRADER_ID = $trader_id";
										$detailqry = oci_parse($conn, $detail);
										oci_execute($detailqry);
                                        while(oci_fetch_array($detailqry)){
                                            $review_count ++;
                                        }
                                    ?>
                                    <div class="huge"><font size="20"><?php echo $review_count; ?></font></div>
                                    <div>Your Products Reviews!!!</div>
                                </div>
                            </div>
                        </div>
                        <a href="myreviews.php">
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
        </div>
    </div>
</div>
</div>
<?php include('includes/script.php'); ?>


