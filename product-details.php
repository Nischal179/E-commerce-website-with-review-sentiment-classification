<?php include 'core/connection.php';
	$pid = $_GET['pid'];
	$productId = $pid;
?>
<?php
error_reporting(0);
?>
<?php include 'includes/head.php';?>
<?php include 'includes/header.php';?>
<?php include 'includes/navbar.php';?>
<?php

	if (isset($_POST['savetocart'])){				
		$quantity = $_POST['qty'];
		$isInCart=0;
		if($quantity>0){
			if(isset($_SESSION['USER_ID'])){
				$USER_ID = $_SESSION['USER_ID'];
				$sql = "SELECT * FROM CART WHERE P_ID = '$productId' AND USERID='$USER_ID'";
			}else{				
				$ip = getRealUserIp();				
				$sql = "SELECT * FROM CART WHERE P_ID = '$productId' AND IP_ADD = '$ip'";
				
			}			
			$query = oci_parse($conn, $sql);
			oci_execute($query);
			while ($row = oci_fetch_array($query)) {
				$isInCart=1;
				
			}
			
			
			if($isInCart==1){
				echo "<script>alert('This product is already added in cart')</script>";
					
			}else{
				$sql = "SELECT * FROM product where PRODUCT_ID = '$productId'";
				$result = oci_parse($conn, $sql);
				oci_execute($result);
				while ($row = oci_fetch_array($result)){					
					$qty = $row['PRODUCT_QUANTITY'];
				}
				
				if($qty<$quantity){					
					if($qty==0){
						echo "<script>alert('Sorry Product Is Out Of Stock')</script>";
					}else{
						echo "<script>alert('Quantity entered is greater than available in stock')</script>";
					}
											
				}else{	
					$ip = getRealUserIp();
											
					if(isset($_SESSION['USER_ID'])){
						$USER_ID = $_SESSION['USER_ID'];
						
						$sql = "INSERT INTO cart (P_ID, QTY, IP_ADD, USERID) VALUES ('$productId','$quantity', '$ip', '$USER_ID')";
						$result = oci_parse($conn, $sql);
						oci_execute($result);						
						echo "<script>alert('New Product is added in cart')</script>";
						echo "<script>window.open('product-details.php?pid=$productId', '_self');</script>";
					}else{
						$sql = "INSERT INTO cart (P_ID, QTY, IP_ADD) VALUES ('$productId','$quantity','$ip')";
						$result = oci_parse($conn, $sql);
						oci_execute($result);						
						echo "<script>alert('New Product is added in cart')</script>";
						echo "<script>window.open('product-details.php?pid=$productId', '_self');</script>";
					}
				}
				
			}
		}else{
			echo "<script>alert('Product Quantity Must Be Greater Than 0')</script>";
		}
	}

	$sql = "SELECT * FROM product WHERE PRODUCT_ID=$pid";
	$result = oci_parse($conn,$sql);
	oci_execute($result);
	while ($row = oci_fetch_assoc($result)) {
		$pName = $row['PRODUCT_NAME'];
		$pPrice = $row['PRODUCT_PRICE'];
		$pQty = $row['PRODUCT_QUANTITY'];
		$sId = $row['PRODUCT_SHOP_ID'];
		$PRODCATEGORY_ID = $row['PRODUCT_CATEGORY_ID'];
		$PRODUCT_PRICE = $row['PRODUCT_PRICE'];
		$PRODUCT_DESCRIPTION = $row['PRODUCT_DESCRIPTION'];
		$PRODUCT_DISCOUNT = $row['PRODUCT_DISCOUNT_PERCENT'];
		$PRODUCT_UDATED_AT = $row['PRODUCT_UDATED_AT'];
		$PRODUCT_CREATED_AT = $row['PRODUCT_CREATED_AT'];
		$imagePath = $row['PRODUCT_IMAGE_PATH'];
		$PRODUCT_OFFER_TITLE = $row['PRODUCT_OFFER_TITLE'];
		$day =0;
		$PRODUCT_ISNEW = 0;
		$daysGap = 0;
		if($PRODUCT_UDATED_AT != null){
			$datetime1 = date_create(substr($PRODUCT_UDATED_AT, 0, 10));
			$datetime2 = date_create(date("Y-m-d"));
			$interval = date_diff($datetime1, $datetime2);
			$interval->format('%R%a days');
			$day = $interval->format('%R%a days');							
			
		}else{
			if($PRODUCT_CREATED_AT != null){
				$datetime1 = date_create(substr($PRODUCT_CREATED_AT, 0, 10));										
				$datetime2 = date_create(date("Y-m-d"));
				$interval = date_diff($datetime1, $datetime2);
				$day = $interval->format('%R%a days');										
			}
		}
		$s = strrpos($day," ");								
		$daysGap = substr($day, 1, $s);								
		$intD = (int)$daysGap;
		if($daysGap!=0 AND $daysGap<=7){
			$PRODUCT_ISNEW = 1;									
		}else{
			$PRODUCT_ISNEW = 0;									
		}		
	}
?>
	<!-- BREADCRUMB -->
	<div id="breadcrumb">
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="index.php">Home</a></li>
				<li><a href="products.php">Products</a></li>
				<?php
					
					if($PRODCATEGORY_ID!=null){
						$sql = "SELECT * FROM PRODUCT_CATEGORY WHERE CATEGORY_ID=$PRODCATEGORY_ID";
						$result = oci_parse($conn,$sql);
						oci_execute($result);
						while ($row = oci_fetch_assoc($result)) {						
							$PRODCATEGORY_NAME = $row['NAME'];
						}
						if($PRODCATEGORY_NAME!=null){
							echo "<li>$PRODCATEGORY_NAME</li>";
						}
					}
				?>
				
				<li class="active"><?php echo $pName;?></li>
			</ul>
		</div>
	</div>
	<!-- /BREADCRUMB -->

	<!-- section -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!--  Product Details -->
				<div class="product product-details clearfix">
					<div class="col-md-6">
						<div id="product-main-view">
							<div class="product-view" style="width: 300px; height: 500px;"> 
								<img style="width: 300px; height: 500px; resize: verticle;" src="<?php echo $imagePath; ?>" alt="Image Not Found">
							</div>
						</div>						
					</div>
					<div class="col-md-6">
						<div class="product-body">
							<div class="product-label">
								<?php
									if($PRODUCT_OFFER_TITLE!=""){																						
										echo "<span>$PRODUCT_OFFER_TITLE</span><br>";
									}
									if($PRODUCT_ISNEW==1 AND $PRODUCT_ISNEW!=null){													
										echo '<span>NEW</span>';
									}
									if($PRODUCT_DISCOUNT>0 AND $PRODUCT_DISCOUNT!=null){
										echo "<span class='sale'>-$PRODUCT_DISCOUNT%</span>";
									}												
								?>
							</div>
							<h2 class="product-name"><?php echo $pName;?></h2>
							<?php
								if($PRODUCT_DISCOUNT>0 AND $PRODUCT_DISCOUNT!=null){
									$PRODUCT_NEW_PRICE = $PRODUCT_PRICE-($PRODUCT_DISCOUNT/100)*$PRODUCT_PRICE;
									echo "<h3 class='product-price'>$$PRODUCT_NEW_PRICE <del class='product-old-price'> $$PRODUCT_PRICE</del></h3>";
								}else{
									echo "<h3 class='product-price'>$$PRODUCT_PRICE</h3>";
								}
							?>
							<div>
								<?php 
									$sql2 = "SELECT * FROM REVIEW WHERE FOREIGN_ID=$pid";
									$result2 = oci_parse($conn,$sql2);
									oci_execute($result2);
									
									$rating = 0;
									$ratingCount = 0;
									$avgRating = 0;
									while ($row = oci_fetch_assoc($result2)){
										$rating += $row['REVIEW_RATING'];
										$ratingCount++;
									}											
									if($ratingCount>0){
										$avgRating = $rating/$ratingCount;
									}
									if($avgRating>0){
										$whole=floor($avgRating);
										$half=$avgRating-$whole;
										$stars = 0;
										echo "<div class='product-rating'>";
										//show whole stars
										for($i=0; $i<$whole; $i++){
											echo "<i class='fa fa-star'></i>";
											$stars++;
										}
										//show a half star
										if($half>0){
											echo "<i class='fa fa-star-half-o'></i>";
											$stars++;
										}
										//show empty stars
										for($i=0; $i<(5-$stars); $i++){
											echo "<i class='fa fa-star-o empty'></i>";
										}
										echo "</div>";
										echo $ratingCount . " Review(s)";
									}										
								?>								
							</div>
							<p><strong>Available Quantity : </strong><?php if($pQty>0){echo "$pQty (In Stock)";}else{echo "$pQty (Out of Stock)";} ?></p>
							<?php
								$sql = "SELECT NAME FROM shop WHERE SHOP_ID= $sId";
								$result = oci_parse($conn,$sql);
								oci_execute($result);
								while ($row = oci_fetch_assoc($result)) {
									$sName = $row['NAME'];
									
								}
							?>
							<p><strong>Shop Name : </strong> <?php echo $sName;?></p>
							<?php echo $PRODUCT_DESCRIPTION;?>
							<form action="" method="post">
								<div class="product-btns">
																		
										<div class="form-group">
											<label class="col-md-1">QTY: </label>
											<input type="number" name="qty">
											<div class="col-md-2">							
											
													
													<?php
														$sql2 = "SELECT * FROM PRODUCT WHERE PRODUCT_ID='$productId'";
														$result2 = oci_parse($conn,$sql2);
														oci_execute($result2);									
														while ($row = oci_fetch_assoc($result2)){
															$PRODUCT_MIN_ORDER = $row['PRODUCT_MIN_ORDER'];
															$PRODUCT_MAX_ORDER = $row['PRODUCT_MAX_ORDER'];
															for($i = $PRODUCT_MIN_ORDER;$i<=$PRODUCT_MAX_ORDER;$i++){
															?>
															
															<option value="<?php echo $i; ?>">
																<?php echo $i; ?>
															</option>
															
															<?php
															}
														}
													?>
												</select>							
											</div>
										</div>
									
									<button name="savetocart" type="submit" class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
									
								</div>
							</form>
						</div>
					</div>
					<div class="col-md-12">
						<div class="product-tab">
							<ul class="tab-nav">
								<li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>								
								<li><a data-toggle="tab" href="#tab2">Reviews</a></li>
							</ul>
							<div class="tab-content">
								<div id="tab1" class="tab-pane fade in active">
									<p><?php echo $PRODUCT_DESCRIPTION;?></p>
								</div>
								<div id="tab2" class="tab-pane fade in">

									<div class="row">
										<div class="col-md-6">
											<div class="product-reviews">
												<?php
													$sql3 = "SELECT * FROM REVIEW WHERE PRODUCT_ID=$pid";
													$result3 = oci_parse($conn,$sql3);
													oci_execute($result3);															
													$rating = 0;															
													while ($row = oci_fetch_assoc($result3)){
														$rating = $row['REVIEW_RATING'];																
														$REVIEW_DESCRIPTION = $row['REVIEW_DESCRIPTION'];
														$dateAdded = $row['REVIEW_CREATED'];
														$USER_ID = $row['USER_ID'];
														
														$sql4 = "SELECT * FROM EUSER WHERE USER_ID=$USER_ID";
														$result4 = oci_parse($conn,$sql4);
														oci_execute($result4);																														
														while ($row = oci_fetch_assoc($result4)){
															$USER_FIRST_NAME = ucfirst($row['USER_FIRST_NAME']);
															$USER_LAST_NAME = ucfirst($row['USER_LAST_NAME']);
															$USER_NAME = $USER_FIRST_NAME . " " . $USER_LAST_NAME;
														}
														echo "<div class='single-review'>";
															echo "<div class='review-heading'>";
																echo "<div><i class='fa fa-user-o'></i> $USER_NAME</a></div>";
																echo "<div><i class='fa fa-clock-o'></i> $dateAdded</a></div>";
																
																echo "<div class='review-rating pull-right'>";
																for($i=0; $i<$rating; $i++){
																	echo "<i class='fa fa-star'></i>";
																	$stars++;
																}
																for($i=0; $i<(5-$rating); $i++){
																	echo "<i class='fa fa-star-o empty'></i>";
																}
																echo "</div>";
																
															echo "</div>";
															echo "<div class='review-body'>";
															echo "<p>" . $REVIEW_DESCRIPTION . "</p>";
															echo "</div>";
														echo "</div>";
														
													}																									
												?>												
											</div>
										</div>
										<div class="col-md-6">
											<h4 class="text-uppercase">Write Your Review</h4>											
											<form class="review-form" method="POST" action="">												
												<div class="form-group">
													<textarea id="txtReview" name="txtReview" class="input" placeholder="Your review"></textarea>
												</div>
												<div class="form-group">
													<div class="input-rating">
														<strong class="text-uppercase">Your Rating: </strong>
														<div class="stars">
															<input type="radio" id="star5" name="rating" value="5" /><label for="star5"></label>
															<input type="radio" id="star4" name="rating" value="4" /><label for="star4"></label>
															<input type="radio" id="star3" name="rating" value="3" /><label for="star3"></label>
															<input type="radio" id="star2" name="rating" value="2" /><label for="star2"></label>
															<input type="radio" id="star1" name="rating" value="1" /><label for="star1"></label>
														</div>
													</div>
												</div>												
												<a class="primary-btn" onclick='save();' ></i>Submit Review</a>
												<!--<button type="submit" name="addReview" class="btn btn-primary">Add Product</button>-->
												<script>
													function save(){
														var isUser = "<?php if(isset($_SESSION['USER_ID'])){echo '1';}else{echo '0';}?>";
														//var isUser = "<?php echo '0';?>";
														//var isUser = 0;
														
														if(isUser=="1"){
															var radios = document.getElementsByName('rating');
															var rating;
															var review = document.getElementById("txtReview").value;
															var ratingChecked = false;
															
															for (var i = 0, length = radios.length; i < length; i++){
																if (radios[i].checked){																	
																	ratingChecked = true;
																	rating = radios[i].value;
																	//alert("Your Review Is Saved");
																	var pid = "<?php echo $pid; ?>";
																	var uid = "<?php echo $_SESSION['USER_ID']; ?>";
																	//alert('You have sucessfully Added a new Review.');window.location.href='myproducts.php';
																	window.open("savereview.php?uid=" + uid + "&fid=" + pid + "&rating=" + rating + "&review=" + review ,"_self");
																	break;
																}
															}
															if(!ratingChecked){
																alert("Please select from 1-5 stars as rating to proceed.");
															}
														}else{
															alert("Please register to give ratings");
														}							
														//document.getElementById("txtReview").value="";
													}
												</script>
												
												
											</form>
											
										</div>
									</div>



								</div>
							</div>
						</div>
					</div>

				</div>
				<!-- /Product Details -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->

<?php include 'includes/footer.php'; ?>