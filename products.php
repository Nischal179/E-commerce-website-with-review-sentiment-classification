<?php include 'core/connection.php';?>
<?php include 'includes/head.php';?>
<title>Products</title>
<?php include 'includes/header.php';?>
<?php include 'includes/navbar.php';?>
<?php
	$serchedText = $_GET['keyword'];	
?>

	<!-- BREADCRUMB -->
	<div id="breadcrumb">
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="index.php">Home</a></li>
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
			<h3 class="m-l-md">Search Results for : <i>" <?php echo $serchedText; ?> "</i></h3>
			<div class="row">
				<!-- MAIN -->
				<div id="main" class="col-md-12">
					<!-- STORE -->
					<div id="store">
						<!-- row -->
						<div class="row">
							<div class="clearfix visible-sm visible-xs"></div>                            
							<?php
								$numberOfProducts = 0;
								$sql = "SELECT * FROM PRODUCT WHERE LOWER(PRODUCT.PRODUCT_NAME) LIKE'%$serchedText%' OR LOWER(PRODUCT.PRODUCT_DESCRIPTION) LIKE'%$serchedText%'";
								$result = oci_parse($conn,$sql);
								oci_execute($result);
								while ($row = oci_fetch_assoc($result)){
								$PRODUCT_ID = $row['PRODUCT_ID'];
								$PRODUCT_NAME = $row['PRODUCT_NAME'];
								$PRODUCT_PRICE = $row['PRODUCT_PRICE'];
								$PRODUCT_DISCOUNT = $row['PRODUCT_DISCOUNT_PERCENT'];
								$PRODUCT_UDATED_AT = $row['PRODUCT_UDATED_AT'];
								$PRODUCT_CREATED_AT = $row['PRODUCT_CREATED_AT'];
								$imagePath = $row['PRODUCT_IMAGE_PATH'];
								$day =0;
								$PRODUCT_ISNEW = 0;
								$daysGap = 0;
								$numberOfProducts ++;
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
									<div class="product-thumb">
										<div class="product-label">
											<?php
												
												if($PRODUCT_ISNEW==1 AND $PRODUCT_ISNEW!=0){
													echo '<span>NEW</span>';
												}
												if($PRODUCT_DISCOUNT>0 AND $PRODUCT_DISCOUNT!=null){
													echo "<span class='sale'>-$PRODUCT_DISCOUNT%</span>";
												}												
											?>
											
										</div>
										<a class="main-btn quick-view" href="<?php echo "product-details.php?pid=" . $PRODUCT_ID ?>"><i class="fa fa-search-plus"></i>Quick view</a>
										<img src="<?php echo $imagePath; ?>" alt="Image Not Found">
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
											$sql2 = "SELECT * FROM REVIEW WHERE FOREIGN_ID=$PRODUCT_ID";
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