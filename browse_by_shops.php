<?php include 'core/connection.php';?>
<?php include 'includes/head.php';?>
<title>Products By Shops</title>
<?php include 'includes/header.php';?>
<?php include 'includes/navbar.php';?>
<?php
	$shop_cat_id = $_GET['sid'];
?>

	<!-- BREADCRUMB -->
	<div id="breadcrumb">
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="index.php">Home</a></li>
				<?php					
					if($shop_cat_id!=null){
						$sql = "SELECT * FROM SHOP_CATEGORY WHERE CATEGORY_ID=$shop_cat_id";
						$result = oci_parse($conn,$sql);
						oci_execute($result);
						while ($row = oci_fetch_assoc($result)) {						
							$SHOPCATEGORY_NAME = $row['NAME'];
						}
						if($SHOPCATEGORY_NAME!=null){
							echo "<li>$SHOPCATEGORY_NAME</li>";
						}
					}
				?>
				<li class="active">Products</li>
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
				<!-- ASIDE -->
				<div id="aside" class="col-md-3">									
					<div class="aside">
						<h3 class="aside-title">SHOPS</h3>
						<div class="list-group">
							<?php
								$sql = "SELECT * FROM SHOP_CATEGORY";
									$result = oci_parse($conn,$sql);
									oci_execute($result);
									while ($row = oci_fetch_assoc($result)){										
										$shopCatName = $row['NAME'];
										$SHOP_CATEGORY_ID = $row['CATEGORY_ID'];										
								?>
								<a href="browse_by_shops.php?sid=<?php echo $SHOP_CATEGORY_ID; ?>" class="list-group-item <?php if ($shop_cat_id==$SHOP_CATEGORY_ID) { echo "active"; } ?>">
									<?php echo $shopCatName; ?>
								</a>
								<?php
							}
							?>
						</div>
					</div>
					<!-- /aside widget -->					
				</div>
				<!-- /ASIDE -->

				<!-- MAIN -->
				<div id="main" class="col-md-9">			

					<!-- STORE -->
					<div id="store">
						<!-- row -->
						<div class="row">
							<div class="clearfix visible-sm visible-xs"></div> 
							<?php
								$numberOfProducts = 0;
								$sql3 = "SELECT * FROM SHOP WHERE SHOP_CATEGORY_ID=$shop_cat_id AND IS_ACTIVE='1'";
								$result3 = oci_parse($conn,$sql3);
								oci_execute($result3);
								while ($row3 = oci_fetch_assoc($result3)){
									$SHOP_ID = $row3['SHOP_ID'];
							?>
							<?php
								
								$sql = "SELECT * FROM product WHERE PRODUCT_SHOP_ID=$SHOP_ID";
								$result = oci_parse($conn,$sql);
								oci_execute($result);
								while ($row = oci_fetch_assoc($result)){
								$numberOfProducts++;
								$PRODUCT_ID = $row['PRODUCT_ID'];
								$PRODUCT_NAME = $row['PRODUCT_NAME'];
								$PRODUCT_PRICE = $row['PRODUCT_PRICE'];
								$PRODUCT_DISCOUNT = $row['PRODUCT_DISCOUNT_PERCENT'];
								$PRODUCT_UDATED_AT = $row['PRODUCT_UDATED_AT'];
								$PRODUCT_CREATED_AT = $row['PRODUCT_CREATED_AT'];
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
								
								
							?>
							<!-- Product Single -->
							<div class="col-md-3 col-sm-4 col-xs-4">
								<div class="product product-single">
									<div style="height:300px; width:200px;" class="product-thumb">
										<div class="product-label">
											<?php
												
												if($PRODUCT_ISNEW==1 AND $PRODUCT_ISNEW!=null){													
													echo '<span>NEW</span>';
												}
												if($PRODUCT_DISCOUNT>0 AND $PRODUCT_DISCOUNT!=null){
													echo "<span class='sale'>-$PRODUCT_DISCOUNT%</span>";
												}												
											?>
											
										</div>										
										<a class="main-btn quick-view" href="<?php echo "product-details.php?pid=" . $PRODUCT_ID ?>"><i class="fa fa-search-plus"></i>Quick view</a>
										<img src="<?php echo $row['PRODUCT_IMAGE_PATH']; ?>" alt="<?php echo "Image Not Found"; ?>">
									</div>
									<div class="product-body">
										<?php
											if($PRODUCT_DISCOUNT>0 AND $PRODUCT_DISCOUNT!=null){
												$PRODUCT_NEW_PRICE = $PRODUCT_PRICE-($PRODUCT_DISCOUNT/100)*$PRODUCT_PRICE;
												echo "<h3 class='product-price'>$$PRODUCT_NEW_PRICE <del class='product-old-price'> $$PRODUCT_PRICE</del></h3>";
											}else{
												echo "<h3 class='product-price'>$$PRODUCT_PRICE</h3>";
											}
										?>
										<?php
											$sql2 = "SELECT * FROM REVIEW WHERE PRODUCT_ID=$PRODUCT_ID";
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
											}										
										?>
										
										<h2 class="product-name"><a href="#"><?php echo $PRODUCT_NAME;?></a></h2>
										
									</div>
								</div>
							</div>
							<!-- /Product Single -->
                                                        
					<?php }?>
					<?php
						}
							if($numberOfProducts==0){
								echo "<div class='col-md-6'>";
								echo "Sorry, There is No Product To Show";
								echo "</div>";
							}
					?>
								
						</div>
						<!-- /row -->
					</div>					
				</div>
				<!-- /MAIN -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->

<?php include 'includes/footer.php'; ?>