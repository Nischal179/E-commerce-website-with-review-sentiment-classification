<?php
	include './includes/functions.php';
	session_start();	
	if(isset($_SESSION['USER_ID'])){
		$USER_ID = $_SESSION['USER_ID'];
		$detail = "SELECT * FROM EUSER WHERE USER_ID = '$USER_ID'";
		$detailqry = oci_parse($conn, $detail);
		oci_execute($detailqry);
		while($row = oci_fetch_assoc($detailqry)){			
			$fname = $row['USER_FIRST_NAME'];			
		}
	}
	
		if(isset($_POST['delete']))	{ 
		$prdctid = $_POST['delete'];
		if(isset($_SESSION['USER_ID'])){
			$sql = "DELETE FROM cart WHERE P_ID = '$prdctid' AND USERID = '$USER_ID'";
		}else{
			$ip_add = getRealUserIp();
			$sql = "DELETE FROM cart WHERE P_ID = '$prdctid' AND IP_ADD = '$ip_add'";
		}
		
  		
  		$result = oci_parse($conn, $sql);
 		oci_execute($result);
	}
?>
</head>
<body>	
<!-- HEADER -->
<header>
	<!-- header -->
	<div id="header">
	
	<!-- /top Header -->
		<div class="container">
			<div class="pull-left">
				<!-- Logo -->
				<div class="header-logo">
					<a class="logo" href="index.php">
						<img src="misc/img/logo.png" alt="">
					</a>
				</div>
				<!-- /Logo -->

				<!-- Search -->
				<div class="header-search">
					
					<form action="" method="post" class="">
						<input class="input" type="text" name="search" placeholder="Enter your keyword">						
						<button class="search-btn" name="btnSearch"><i class="fa fa-search"></i></button>
					</form>
				</div>
				<?php
					if(isset($_POST['btnSearch'])){
						if (!empty($_POST["search"])){
							$keyword = $_POST["search"];							
							header("location: products.php?keyword=$keyword");
						}						
					}
				?>
				<!-- /Search -->
			</div>
			<div class="pull-right">				
				<ul class="header-btns">
					<?php
						if(isset($_SESSION['USER_ID'])){
							echo "<li><ul><strong class='text-uppercase'>Welcome, " . $fname . "</strong></ul></li>";
						}
						//**********CART***********
						if(isset($_SESSION['USER_ID'])){
							$usrid = $_SESSION['USER_ID'];
							$sql = "SELECT * FROM cart WHERE USERID = '$usrid'";
						}else{
							$ip_add = getRealUserIp();
							$sql = "SELECT * FROM cart WHERE ip_add = '$ip_add'";
						}				
						$query = oci_parse($conn, $sql);
						oci_execute($query);
						$cart = 0;
						while($row = oci_fetch_array($query)){
							$cart++;
						}
						//**********CART***********
					?>					
					
					<!-- Cart -->
					<li class="header-cart dropdown default-dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
							<div class="header-btns-icon">
								<i class="fa fa-shopping-cart"></i>
								<span class="qty"><?php echo $cart; ?></span>
							</div>							
							<br>							
						</a>
						<div class="custom-menu">
							<div id="shopping-cart">
								<div class="shopping-cart-list">
								<!-- ************************ CART ************************** -->
                              <?php
								if(isset($_SESSION['USER_ID'])){
									$sql = "SELECT * FROM cart WHERE USERID = '$USER_ID'";
								}else{
									$sql = "SELECT * FROM cart WHERE ip_add = '$ip_add'";
								}                                
                                $query = oci_parse($conn, $sql);
                                oci_execute($query);
                                while ($row = oci_fetch_array($query)) {
									?>

									<div class="product product-widget">
										<?php
											$prdid = $row['P_ID'];
											$sql1 = "SELECT * FROM PRODUCT WHERE PRODUCT_ID = '$prdid'";
											$result5 = oci_parse($conn, $sql1);
											oci_execute($result5);
											while ($row1 = oci_fetch_array($result5)){
												$price = $row1['PRODUCT_PRICE'];
												$name = $row1['PRODUCT_NAME'];
												$imagePath = $row1['PRODUCT_IMAGE_PATH'];
												$PRODUCT_DISCOUNT = $row1['PRODUCT_DISCOUNT_PERCENT'];
												if($PRODUCT_DISCOUNT>0 AND $PRODUCT_DISCOUNT!=null){
													$price = $price-($PRODUCT_DISCOUNT/100)*$price;
												}
											}
											
									
										?>
									
										<div class="product-thumb">
											<img src="<?php echo $imagePath?>" alt="Image Not Found">
										</div>
                                        
                                        
										<div class="product-body">
											<h3 class="product-price"><?php echo '$'.$price?> X <?php echo $row['QTY'];?></h3>
											<h2 class="product-name"><a href="#"> <?php echo $name;?></a></h2>
										</div>
                                        <form action="" method="post">
												<button name="delete" class="cancel-btn" value="<?php echo $prdid;?>"><i class="fa fa-trash"></i></button>
                                        </form>
									</div>
									<br>
                                     <?php } ?>
									<!-- ************************ CART ************************** -->

								</div>
								<div class="shopping-cart-btns">
									<!-- <button class="main-btn">View Cart</button> -->
                                    <a href="viewcart.php"><button class="primary-btn">View Cart Details<i class="fa fa-arrow-circle-right"></i></button></a>
								</div>
							</div>
						</div>
					</li>
					<!-- /Cart -->
					
					<!-- Account -->
					<li class="header-account dropdown default-dropdown">
						<div class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="true">
							<div class="header-btns-icon">
								<i class="fa fa-user-o"></i>
							</div>							
							<strong class="text-uppercase">My Account <i class="fa fa-caret-down"></i></strong>
						</div>
						<?php 
							if(!isset($_SESSION['USER_ID'])){
								echo "<a href='login.php' class=''><b>Login</b></a> / <a href='register.php' class=''><b>Register</b></a>";
							}else{
								echo "<a href='logout.php' class='text-uppercase'>Logout <i class='fa fa-sign-out'></i></a>";
							}
						?>
						
						
						<ul class="custom-menu">
							
							
							
							<?php 
								if(isset($_SESSION['USER_ID'])){
									if(isset($_SESSION['USER_TYPE'])){
										$type = $_SESSION['USER_TYPE'];
										if(strtoupper($type)=="CUSTOMER"){											
											echo "<li><a href='customer/viewuser.php'><i class='fa fa-user-o'></i> My Account</a></li>";
										}else if(strtoupper($type)=="TRADER"){											
											echo "<li><a href='trader/home.php'><i class='fa fa-user-o'></i> My Account</a></li>";
										}else if(strtoupper($type)=="ADMIN"){											
											echo "<li><a href='admin/home.php'><i class='fa fa-user-o'></i> My Account</a></li>";
										}else{}
									}else{
										echo "<li><a href='#'><i class='fa fa-user-o'></i> My Account</a></li>";
									}
									
								}
							?>
							<li><a href="viewcart.php"><i class="fa fa-check"></i> View Cart</a></li>
							<?php 
								if(isset($_SESSION['USER_ID'])){
									echo "<li><a href='logout.php'><i class='fa fa-sign-out'></i> Log Out</a></li>";
								}else{
									
									echo "<li><a href='login.php'><i class='fa fa-unlock-alt'></i> Login</a></li>";
									echo "<li><a href='register.php'><i class='fa fa-user-plus'></i> Create An Account</a></li>";
								}
							?>
							
							
						</ul>
					</li>
					<!-- /Account -->

					

					<!-- Mobile nav toggle-->
					<li class="nav-toggle">
						<button class="nav-toggle-btn main-btn icon-btn"><i class="fa fa-bars"></i></button>
					</li>
					<!-- / Mobile nav toggle -->
				</ul>
			</div>
			
		</div>
		<!-- header -->		
	</div>
	<!-- container -->
</header>
<!-- /HEADER -->