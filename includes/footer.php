<!-- FOOTER -->
<footer id="footer" class="section section-grey">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!-- footer widget -->
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="footer">
						<!-- footer logo -->
						<!-- <div class="footer-logo">
							<a class="logo" href="#">
		            <img src="misc/img/logo.png" alt="">
		          </a>
						</div> -->
						<!-- /footer logo -->

						<p>A Local Hub For All Your Shopping Needs</p>

						<!-- footer social -->
						<ul class="footer-social">
							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#"><i class="fa fa-instagram"></i></a></li>
							<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							<li><a href="#"><i class="fa fa-pinterest"></i></a></li>
						</ul>
						<!-- /footer social -->
					</div>
				</div>
				<!-- /footer widget -->

				<!-- footer widget -->
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="footer">
						<h3 class="footer-header">My Account</h3>
						<ul class="list-links">
							<?php 
								if(isset($_SESSION['USER_ID'])){
									if(isset($_SESSION['USER_TYPE'])){
										$type = $_SESSION['USER_TYPE'];
										if(strtoupper($type)=="USER"){											
											echo "<li><a href='customer/viewuser.php'>My Account</a></li>";
										}else if(strtoupper($type)=="TRADER"){											
											echo "<li><a href='trader/home.php'>My Account</a></li>";
										}else if(strtoupper($type)=="ADMIN"){											
											echo "<li><a href='admin/home.php'>My Account</a></li>";
										}else{}
									}else{
										echo "<li><a href='#'>My Account</a></li>";
									}
									
								}
							?>														
							<li><a href="login.php">Login</a></li>
						</ul>
					</div>
				</div>
				<!-- /footer widget -->

				<div class="clearfix visible-sm visible-xs"></div>

				<!-- footer widget -->
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="footer">
						<h3 class="footer-header">Customer Service</h3>
						<ul class="list-links">
							<li><a href="aboutus.php">About Us</a></li>
							
						</ul>
					</div>
				</div>
				<!-- /footer widget -->
				
			</div>
			<!-- /row -->
			<hr>
			<!-- row -->
			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center">
					<!-- footer copyright -->
					<div class="footer-copyright">
						<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | ShopHub
						<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
					</div>
					<!-- /footer copyright -->
				</div>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</footer>
	<!-- /FOOTER -->

<!-- jQuery Plugins -->
<script src="misc/js/jquery.min.js"></script>
<script src="misc/js/bootstrap.min.js"></script>
<script src="misc/js/slick.min.js"></script>
<script src="misc/js/nouislider.min.js"></script>
<script src="misc/js/jquery.zoom.min.js"></script>
<script src="misc/js/main.js"></script>

</body>

</html>