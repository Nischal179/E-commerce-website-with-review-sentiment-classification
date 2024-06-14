	<!-- NAVIGATION -->
	<div id="navigation">
		<!-- container -->
		<div class="container">
			<div id="responsive-nav">
				<!-- menu nav -->
				<div class="menu-nav">
					<span class="menu-header">Menu <i class="fa fa-bars"></i></span>
					<ul class="menu-list">

						<li><a href="index.php">Home</a></li>	

						
						<li class="dropdown dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Products <i class="fa fa-caret-down"></i></a>
							<div class="custom-menu">
								<div class="row">
									<div class="col-md-12">
										<ul class="list-links">				
											<?php
												$sql = "SELECT * FROM PRODUCT_CATEGORY";
												$result = oci_parse($conn,$sql);
												oci_execute($result);
												while ($row = oci_fetch_assoc($result)){
													$catid = $row['CATEGORY_ID'];
													$catName = $row['NAME'];
													echo "<li><a href='browse_by_categories.php?cid=". $catid ."'> " . $catName . "</a></li>";
												}
											?>															
											
										</ul>
										<hr class="hidden-md hidden-lg">
									</div>									
								</div>
							</div>
							
						<li class="dropdown dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Shops <i class="fa fa-caret-down"></i></a>
							<div class="custom-menu">
								<div class="row">
									<div class="col-md-12">
										<ul class="list-links">				
											<?php
												$sql = "SELECT * FROM SHOP_CATEGORY";
												$result = oci_parse($conn,$sql);
												oci_execute($result);
												while ($row = oci_fetch_assoc($result)){
													$scid = $row['CATEGORY_ID'];
													$sName = $row['NAME'];
													echo "<li><a href='browse_by_shops.php?sid=". $scid ."'> " . $sName . "</a></li>";
												}
											?>									
											
											
										</ul>
										<hr class="hidden-md hidden-lg">
									</div>									
								</div>
							</div>						
						
						<li><a href="aboutus.php">About Us</a></li>						

					</ul>
				</div>
				<!-- menu nav -->
			</div>
		</div>
		<!-- /container -->
	</div>
	<!-- /NAVIGATION -->