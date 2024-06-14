<?php include 'includes/head.php';?>
<title>ShopHub</title>
<?php include 'includes/header.php';?>
<?php include 'includes/navbar.php';?>

	<!-- HOME -->
	<div id="home">
		<!-- container -->
		<div class="container">
			<!-- home wrap -->
			<div class="home-wrap">
				<!-- home slick -->
				<div id="home-slick">
					<!-- banner -->
					<div class="banner banner-1">
						<img src="misc/img/banner01.jpg" alt="">
						<!-- <div class="banner-caption text-center">
							<h1 class="primary-color">Bakery<br><span class="white-color font-weak">Fresh Bakery Products</span></h1>							
						</div> -->
					</div>
					<!-- /banner -->

					<!-- banner -->
					<div class="banner banner-1">
						<img src="misc/img/banner02.jpg" alt="">
						<!-- <div class="banner-caption text-center">
							<h1 class="primary-color">Green Groceries<br><span class="white-color font-weak">Organic and Healthy</span></h1>							
						</div> -->
					</div>
					<!-- /banner -->

					<!-- banner -->
					<div class="banner banner-1">
						<img src="misc/img/banner03.jpg" alt="">
						<!-- <div class="banner-caption text-center">
							<h1 class="white-color">Delicatessen Products</h1>							
						</div> -->
					</div>
					<!-- /banner -->
				</div>
				<!-- /home slick -->
			</div>
			<!-- /home wrap -->
		</div>
		<!-- /container -->
	</div>
	<!-- /HOME -->


	<!-- section -->
	<div class="section section-grey">
		<!-- container -->
		<div class="container">

			<!-- row -->
			<div class="row">
			
			
			
				<!-- section title -->
				<div class="col-md-12">
					<div class="section-title">
						<h2 class="title">Products On Discount</h2>
						<div class="pull-right">
							<div class="product-slick-dots-2 custom-dots">							
							</div>
						</div>
					</div>
				</div>
				<!-- section title -->
<?php
					$numberOfProducts = 0;
					$sql = "SELECT * FROM product WHERE PRODUCT_DISCOUNT_PERCENT>'0'";
					$result = oci_parse($conn,$sql);
					oci_execute($result);
					while ($row = oci_fetch_assoc($result) AND $numberOfProducts<8){
					$PRODUCT_ID = $row['PRODUCT_ID'];
					$PRODUCT_NAME = $row['PRODUCT_NAME'];
					$PRODUCT_PRICE = $row['PRODUCT_PRICE'];
					$PRODUCT_DISCOUNT = $row['PRODUCT_DISCOUNT_PERCENT'];
					$PRODUCT_UDATED_AT = $row['PRODUCT_UDATED_AT'];
					$PRODUCT_CREATED_AT = $row['PRODUCT_CREATED_AT'];					
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
				<div class="col-md-3 col-sm-6 col-xs-6">
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
							<img style="height:300px; width:200px;" src="<?php echo $row['PRODUCT_IMAGE_PATH']; ?>" alt="<?php echo "Image Not Found"; ?>">
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
			<?php }?>
							<!-- /Product Single -->

						</div>
					</div>
				</div>
				<!-- /Product Slick -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->
	

	<!-- section -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!-- section title -->
				<div class="col-md-12">
					<div class="section-title">
						<h2 class="title">Products</h2>
					</div>
				</div>
				<!-- section title -->


			<!-- row -->
			<div class="row">
				<?php
					$numberOfProducts = 0;
					$sql = "SELECT * FROM product";
					$result = oci_parse($conn,$sql);
					oci_execute($result);
					while ($row = oci_fetch_assoc($result) AND $numberOfProducts<12){
					$PRODUCT_ID = $row['PRODUCT_ID'];
					$PRODUCT_NAME = $row['PRODUCT_NAME'];
					$PRODUCT_PRICE = $row['PRODUCT_PRICE'];
					$PRODUCT_DISCOUNT = $row['PRODUCT_DISCOUNT_PERCENT'];
					$PRODUCT_UDATED_AT = $row['PRODUCT_UDATED_AT'];
					$PRODUCT_CREATED_AT = $row['PRODUCT_CREATED_AT'];					
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
			
				<div class="col-md-3 col-sm-6 col-xs-6">
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
							<img style="height:300px; width:200px;" src="<?php echo $row['PRODUCT_IMAGE_PATH']; ?>" alt="<?php echo "Image Not Found"; ?>">
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
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->

<?php include 'includes/footer.php'; ?>