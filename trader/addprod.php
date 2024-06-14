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
$error_count = 0;
$isUsed = false;
if (isset($_POST['addprod'])){
	unset($_POST['addprod']);
	$prdCatId = $shopId = $txtName = $txtDesc = $txtAllergy = $txtSpc = $txtSf = $txtSt = "";
	$txtPrice = $txtQuantity = $txtDis = 0;
	date_default_timezone_set('Asia/Kathmandu');
	$date = date("Y-m-d h:i:sA");
	
	$prdCatId = $_POST["prdCatId"];
	$shopId = $_POST["shopId"];
	$txtName = $_POST["txtName"];
	$txtDesc = $_POST["txtDesc"];
	$txtPrice = $_POST["txtPrice"];
	$txtQuantity = $_POST["txtQuantity"];
	$txtAllergy = $_POST["txtAllergy"];
	$txtSpc = $_POST["txtSpc"];	
	$txtDis = $_POST["txtDis"];
	$txtSf = $_POST["txtSf"];
	$txtSt = $_POST["txtSt"];	
	$product_image = $_FILES['product_image']["name"];
		
    $maxsize = 2097152;
    $img_haystack = array('jpg', 'jpeg', 'png');
    $image_filter = array('image/jpeg', 'image/jpg', 'image/png');
    if (!empty($product_image)) {
		$target_dir = "../media/";
		$target_file = $target_dir . basename($_FILES["product_image"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
		if (!in_array($imageFileType, $img_haystack)) {
			$errors['invalid_img'] = "Invalid file type. Only JPG and PNG types are accepted.";
		} else {
			$flag = 1;
		}
		if ($flag) {
			$imgSize = $_FILES["product_image"]["size"];
			if ($imgSize > $maxsize) {
				$errors['max'] = 'File you\'re trying to upload is too large. File must be less than 2 megabytes.';
			}
		}
		$check = getimagesize($_FILES["product_image"]["tmp_name"]);
		if ($check !== false) {
			$uploadOk = 1;
			$imgPath = $target_dir . uniqid() . '.' . $imageFileType;
			if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $imgPath)) {
			} else {
				$errors['fail'] = "Sorry, there was an error uploading your file.";
			}
		}		
		$imgPath = substr($imgPath,3,strlen($imgPath)-3);
	}else{
		$imgPath = "";
	}
        
		$sql = "INSERT INTO PRODUCT (PRODUCT_ID, PRODUCT_SHOP_ID, PRODUCT_CATEGORY_ID, PRODUCT_NAME, PRODUCT_DESCRIPTION, PRODUCT_PRICE, PRODUCT_OFFER_TITLE, PRODUCT_DISCOUNT_PERCENT, 
		PRODUCT_SPECIAL_FROM, PRODUCT_SPECIAL_TO, PRODUCT_QUANTITY, PRODUCT_ALLEGERY_INFO, PRODUCT_IMAGE_PATH, PRODUCT_CREATED_AT) VALUES 
		(seq_product.nextval, '$shopId','$prdCatId','$txtName', '$txtDesc', '$txtPrice', '$txtSpc', '$txtDis', '$txtSf', '$txtSt', '$txtQuantity', '$txtAllergy', '$imgPath', '$date')";
		$result = oci_parse($conn,$sql);		
		oci_execute($result);
		
        if ($sql){			
			echo "<script>alert('You have sucessfully Added a new Product.');window.location.href='myproducts.php';</script>";            
        } 

	 
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
       	Add Product
      </h1>
      <ol class="breadcrumb">
        <li><a href="../../../index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Product</li>
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
					<div class="form-group">
						<label class="col-md-3">Product of</label>
						<div class="col-md-9">							
							<select class="form-control" name="shopId">								
								<?php
									$sql2 = "SELECT * FROM SHOP WHERE TRADER_ID=$trader_id";
									$result2 = oci_parse($conn,$sql2);
									oci_execute($result2);									
									while ($row = oci_fetch_assoc($result2)){									
										?>
										<option value="<?php echo $row['SHOP_ID']; ?>">
											<?php echo $row['NAME']; ?>
										</option>
										<?php
									}
								?>
							</select>							
						</div>
					</div>
					
					<br><br>
					
					<div class="form-group">
						<label class="col-md-3">Product Category</label>
						<div class="col-md-9">							
							<select class="form-control" name="prdCatId">								
								<?php
									$sql2 = "SELECT * FROM PRODUCT_CATEGORY";
									$result2 = oci_parse($conn,$sql2);
									oci_execute($result2);									
									while ($row = oci_fetch_assoc($result2)){									
										?>
										<option value="<?php echo $row['CATEGORY_ID']; ?>">
											<?php echo $row['NAME']; ?>
										</option>
										<?php
									}
								?>
							</select>							
						</div>
					</div>
					<br><br>	
					
						
                <div class="form-group">
                  <label for="exampleInputName">Name</label>
                  <input type="text" required class="form-control" id="Name" placeholder="Enter name" name="txtName">
                </div>
                <div class="form-group">
                  <label for="exampleInputDescription">Description</label>
                  <input type="text" required class="form-control" id="Desc" placeholder="Enter description" name="txtDesc">
                </div>
               	<div class="form-group">
                  <label for="exampleInputPrice">Price</label>
                  <input type="number" required class="form-control" id="Price" placeholder="Enter Price" name="txtPrice">
                </div>
				<div class="form-group">
                  <label for="exampleInputQuantity">Quantity</label>
                  <input type="number" required class="form-control" id="Quantity" placeholder="Enter quantity" name="txtQuantity">
                </div>
               	<div class="form-group">
                  <label for="exampleInputAllergy">Allergy Info</label>
                  <input type="text" class="form-control" id="Allergy" placeholder="Enter any allergy info the product might have" name="txtAllergy">
                </div>
				<div class="form-group">
                  <label for="exampleInputPrice">Special Offer Title</label>
                  <input type="text" class="form-control" id="Spc" placeholder="Enter Special Offer Title" name="txtSpc">
                </div>
				<div class="form-group">
                  <label for="exampleInputPrice">Discount %</label>
                  <input type="number" class="form-control" id="Dis" placeholder="Enter Discount %" name="txtDis">
                </div>
				<div class="form-group">
                  <label for="exampleInputPrice">Special From</label>
                  <input class="form-control" id="Sf" name="txtSf" placeholder="Choose Date" >
				  
                </div>
				
				<div class="form-group">
                  <label for="exampleInputPrice">Special To</label>
                  <input type="text" class="form-control" id="St" placeholder="Choose Date" name="txtSt">		  

                </div>							
               
                <div class="form-group">
                  <label for="exampleInputFile">Choose thumbnail</label>
                  <input type="file" name="product_image">

                  <p class="help-block">Upload an appropriate image for the product.</p>
                </div>
               </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="addprod" class="btn btn-primary">Add Product</button>
              </div>
            </form>
          </div>
      </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2023 <a href="">ShopHub</a>.</strong> All rights
    reserved.
  </footer>
<script type="text/javascript">    
    $(function() {
        $('#Sf').datepicker('show'){
            format: 'YYYY-MM-DD'
        });
    });  

</script>
<!-- ./wrapper -->
<?php include('includes/script.php'); ?>
</body>
</html>
