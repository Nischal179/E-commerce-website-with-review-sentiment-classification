<?php include 'core/connection.php';?>
<?php include 'includes/head.php';?>
<title>Shops</title>
<?php include 'includes/header.php';?>
<?php include 'includes/navbar.php';?>

	<!-- BREADCRUMB -->
	<div id="breadcrumb">
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="#">Home</a></li>
				<li class="active">Shops</li>
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

				<!-- MAIN -->
				<div id="main" class="col-md-12">
					<!-- store top filter -->
					<div class="store-filter clearfix">
						<div class="pull-left">							
							<div class="sort-filter">
								<span class="text-uppercase">Sort By Category:</span>
								<select class="input">
										<option class="select_category">Select</option>
										<option value="0">Category A</option>
										<option value="0">Category B</option>
										<option value="0">Category C</option>
										<option value="0">Category D</option>
										<option value="0">Category E</option>
								</select>
								<a href="#" class="main-btn icon-btn"><i class="fa fa-arrow-down"></i></a>
							</div>
						</div>
						<div class="pull-right">
							<div class="page-filter">
								<span class="text-uppercase">Show:</span>
								<select class="input">
										<option value="0">10</option>
										<option value="1">20</option>
										<option value="2">30</option>
									</select>
							</div>
							<ul class="store-pages">
								<li><span class="text-uppercase">Page:</span></li>
								<li class="active">1</li>
								<li><a href="#">2</a></li>
								<li><a href="#">3</a></li>
								<li><a href="#"><i class="fa fa-caret-right"></i></a></li>
							</ul>
						</div>
					</div>
					<!-- /store top filter -->
					
					<?php
						$sql = "SELECT * FROM shop";
						$result = oci_parse($conn,$sql);
						oci_execute($result);
						while ($row = oci_fetch_assoc($result)) {
						$SHOP_ID = $row['SHOP_ID'];
						$SHOP_NAME = $row['SHOP_NAME'];
					?>

					<!-- STORE -->
					<div id="store">
						<!-- row -->
						<div class="row">
							<!-- Product Single -->
							<div class="col-md-4 col-sm-6 col-xs-6">
								<div class="product product-single">
									<div class="product-thumb">
										<button class="main-btn quick-view"><a href="<?php echo "shop-details.php?sid=" . $SHOP_ID ?>"><i class="fa fa-search-plus"></i> Quick view</button>
										<img src="./img/blank_original.jpg" alt="">
									</div>
									<div class="product-body">									
										<h3 class="product-price"><?php echo $row['SHOP_NAME'];?></h3>
										
										<?php 
											$sql2 = "SELECT * FROM REVIEW WHERE FOREIGN_ID=$SHOP_ID";
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
										
										<div class="product-btns">
											<button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> View Shop</button>
										</div>
									</div>
								</div>
							</div>
							<!-- /Product Single -->
						<?php }?>
						
						</div>
						<!-- /row -->
					</div>
					<!-- /STORE -->

					<!-- store bottom filter -->
					<div class="store-filter clearfix">						
						<div class="pull-right">							
							<ul class="store-pages">
								<li><span class="text-uppercase">Page:</span></li>
								<li class="active">1</li>
								<li><a href="#">2</a></li>
								<li><a href="#">3</a></li>
								<li><a href="#"><i class="fa fa-caret-right"></i></a></li>
							</ul>
						</div>
					</div>
					<!-- /store bottom filter -->
				</div>
				<!-- /MAIN -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->

<?php include 'includes/footer.php'; ?>	