<?php
include 'core/connection.php';
include 'includes/functions.php';
 
error_reporting(0);
 
session_start();
if(isset($_SESSION['USER_ID'])){
	$USER_ID = $_SESSION['USER_ID'];	
}else{
	header('location:../login.php');
}
date_default_timezone_set('Asia/Kathmandu');
$date = date('m/d/Y');
$invoice = mt_rand();
$select_customer ="SELECT * FROM EUSER WHERE USER_ID ='$USER_ID'";
$run_customer =oci_parse($conn, $select_customer);
oci_execute($run_customer);
$row_customer =oci_fetch_array($run_customer);
$customer_id =$row_customer['USER_ID'];
$email = $row_customer['USER_EMAIL'];


$totalprice = 0;
?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="assets/paypal/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/paypal/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="assets/paypal/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">


  <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Invoice
        <small><?php echo $invoice?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Invoice</li>
      </ol>
    </section>

    <div class="pad margin no-print">
      <div class="callout callout-info" style="margin-bottom: 0!important;">
        <h4><i class="fa fa-info"></i> Note:</h4>
        This page has been enhanced for printing. Click the print button at the bottom of the invoice to print this page.
      </div>
    </div>

    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> ShopHub, Inc.
            <small class="pull-right">Date: <?php echo $date?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <!-- /.col -->
        <div class="col-sm-4 invoice-col col-md-offset-9">
          <b>Invoice #<?php echo $invoice?></b><br>
          <b>Account:</b> <?php echo $email?><br>
		  <?php
			date_default_timezone_set('Asia/Kathmandu');											
			$date = date('Y-m-d');
			$day = date('l', strtotime($date));
			$day = strtoupper($day);
			$hour = date('H');
			$min = date('i');											
			$timeslot = "";
			if($day=="FRIDAY" OR $day=="SATURDAY" OR $day=="SUNDAY" OR $day=="MONDAY"){
				$date = date('Y-m-d', strtotime("next wednesday"));
				$timeslot = "10AM-1PM";
			}else{								
				
				if($day=="TUESDAY" AND $hour<=19){
					if($hour==19 AND $min!=0){
						$date = date('Y-m-d', strtotime($date. ' +2 days'));														
						$timeslot = "10AM-1PM";														
					}else{
						$date = date('Y-m-d', strtotime($date. ' +1 days'));
						$timeslot = getTimeSlot($hour,$min);
						if($timeslot==""){
							$date = date('Y-m-d', strtotime($date. ' +1 days'));
							$timeslot = "10AM-1PM";
						}
					}
				}else{
					if($day=="TUESDAY" AND $hour>19){
						$date = date('Y-m-d', strtotime($date. ' +2 days'));													
						$timeslot = "10AM-1PM";
					}
				}
				if($day=="WEDNESDAY" AND $hour<=19){
					if($hour==19 AND $min!=0){														
						$date = date('Y-m-d', strtotime($date. ' +2 days'));														
						$timeslot = "10AM-1PM";														
					}else{
						$date = date('Y-m-d', strtotime($date. ' +1 days'));
						$timeslot = getTimeSlot($hour,$min);
						if($timeslot==""){
							$date = date('Y-m-d', strtotime($date. ' +1 days'));
							$timeslot = "10AM-1PM";
						}
					}
				}else{
					if($day=="WEDNESDAY" AND $hour>19){
						$date = date('Y-m-d', strtotime($date. ' +2 days'));													
						$timeslot = "10AM-1PM";
					}
				}
				if($day=="THURSDAY" AND $hour<=19){
					
					if($hour==19 AND $min!=0){
						$date = date('Y-m-d', strtotime('next wednesday', strtotime($date)));
						$timeslot = "10AM-1PM";													
					}else{
						
						$timeslot = getTimeSlot($hour,$min);
						if($timeslot==""){															
							$date = date('Y-m-d', strtotime('next wednesday', strtotime($date)));															
							$timeslot = "10AM-1PM";
						}else{															
							$date = date('Y-m-d', strtotime($date. ' +1 days'));
						}
					}
				}else{
					if($day=="THURSDAY" AND $hour>19){
						$date = date('Y-m-d', strtotime('next wednesday', strtotime($date)));													
						$timeslot = "10AM-1PM";
					}
				}									
				
				
			}											
			function getTimeSlot($hour,$min){
				$timeslot = "";												
				if($hour<=13){
					if($hour==13 AND $min!=0){
						$timeslot = "1PM-4PM";
						
						
					}else{
						$timeslot = "10AM-1PM";
						
					}
				}else if($hour>=13 AND $hour<=16){
					if($hour==16 AND $min!=0){
						$timeslot = "4PM-7PM";
						
					}else{														
						$timeslot = "1PM-4PM";
						
					}
				}else if($hour>=16 AND $hour<=19){
					if($hour==19 AND $min!=0){
						$timeslot = "";
						
					}else{
						$timeslot = "4PM-7PM";
						
					}
				}else{}												
				return $timeslot;
			}
		?>
		  <b>Pickup Available After : </b><font size="5"><?php echo $date . ' ' . $timeslot;?></font>
          
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <br>
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Qty</th>
              <th>Name</th>
              <th>Discount</th>
              <th>Description</th>
              <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            <?php
				
				$sql = "SELECT * FROM cart WHERE USERID = '$USER_ID'";
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
					//TODO
					$total = $row2['PRODUCT_PRICE']*$row['QTY'];
					$totalafterdis = $total - (($row2['PRODUCT_DISCOUNT_PERCENT']/100)*$total);
					$totalprice += $totalafterdis;
					?>
									

              <td><?php echo $row['QTY'];?></td>
              <td><?php echo $row2['PRODUCT_NAME'];?></td>
              <td><?php if($row2['PRODUCT_DISCOUNT_PERCENT']==""){echo '0'.'%';}else{echo $row2['PRODUCT_DISCOUNT_PERCENT'].'%';}?></td>
              <td><?php echo $row2['PRODUCT_DESCRIPTION'];?></td>
              <td><?php echo '$'.$totalafterdis;?></td>
            </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- /.col -->
        <div class="col-xs-6 col-md-offset-6">
          
          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Subtotal:</th>
                <td><?php echo '$'.$totalprice?></td>
              </tr>
              
              <tr>
                <th>Total:</th>
                <td><?php echo '$'.$totalprice?></td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      
      <?php
		  $get_cart ="SELECT * FROM CART WHERE USERID='$USER_ID'";
          $run_cart=oci_parse($conn	, $get_cart);
          oci_execute($run_cart);
 		  
		  
		  while ( $row_cart =oci_fetch_array($run_cart)) {
            
 		   $pro_id =$row_cart['P_ID'];
 		   $get_products="SELECT * FROM PRODUCT WHERE PRODUCT_ID='$pro_id'";
 		   $run_products=oci_parse($conn, $get_products);
 		   oci_execute($run_products);
 		   $row_products =oci_fetch_array($run_products);
 		   $product_shop =$row_products['PRODUCT_SHOP_ID'];
		   $PRODUCT_PRICE =$row_products['PRODUCT_PRICE'];
		   $PRODUCT_DISCOUNT_PERCENT =$row_products['PRODUCT_DISCOUNT_PERCENT'];
		   $sqltrader = "SELECT * FROM SHOP WHERE SHOP_ID = '$product_shop'";
		   
		   $trader = oci_parse($conn, $sqltrader);
		   oci_execute($trader);
		   $row_traders = oci_fetch_array($trader);
		   $trader_id = $row_traders['TRADER_ID'];
		   
 			
			if($PRODUCT_DISCOUNT>0 && $PRODUCT_DISCOUNT!=null){
				$PRODUCT_PRICE = $PRODUCT_PRICE-($PRODUCT_DISCOUNT/100)*$PRODUCT_PRICE; 
			}			
			//TODO
			$total = $PRODUCT_PRICE*$row_cart['QTY']; 
			
			$paymentsql = "INSERT INTO PAYMENT(PAYMENT_ID, INVOICE_ID, USER_EMAIL, TRADER_ID, PRICE, PAYMENT_DATE, DELIVERY_DATE, DELIVERY_TIMESLOT) VALUES (PAY_SEQ.nextval, $invoice, '$email', $trader_id, $total, TO_DATE('$date', 'MM/DD/YY'), $date, $timeslot)";	  
		  $result = oci_parse($conn, $paymentsql);
			oci_execute($result);
		  
			$quantity = $row_products['PRODUCT_QUANTITY'] - $row_cart['QTY'];			
			$qtysql = "UPDATE PRODUCT SET PRODUCT_QUANTITY =$quantity WHERE PRODUCT_ID=$pro_id"; 
			$qtyresult = oci_parse($conn, $qtysql);
			oci_execute($qtyresult);
			
			$deletesql = "DELETE FROM CART WHERE USERID = '$USER_ID'";
			$delresult = oci_parse($conn, $deletesql);
			oci_execute($delresult);		
				   
		  }

	  
	  ?>

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <a onCLick="window.print()" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
          <a href="index.php"><button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Return to ShopHub
          </button>
          
        </div>
      </div>
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer no-print">
    <strong>Copyright &copy; 2023 <a>ShopHub</a>.</strong> All rights reserved.
  </footer>

<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="assets/dist/js/demo.js"></script>
</body>
</html>
