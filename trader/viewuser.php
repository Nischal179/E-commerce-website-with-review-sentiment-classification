<?php
	session_start();
	if(isset($_SESSION['USER_ID'])){
		$USER_ID = $_SESSION['USER_ID'];	
	}else{
		header('location:../login.php');
	}
include ('../core/connection.php');
include ('../includes/imageupload.php');
	
	$fname = "N/A";
	$lname = "N/A";
	$email = "N/A";
	$address = "N/A";
	$created = "N/A";				

	$sql = "SELECT * FROM  EUSER WHERE USER_ID= '$USER_ID'";	
	$result = oci_parse($conn,$sql);	
	oci_execute($result);
	while($row = oci_fetch_assoc($result)){
		$userid = $row['USER_ID'];
		$fname = $row['USER_FIRST_NAME'];
		$lname = $row['USER_LAST_NAME'];
		$email = $row['USER_EMAIL'];
		$address = $row['USER_ADDRESS'];
		$created = $row['USER_CREATED_AT'];
		
		if($fname == ""){
			$fname = "Not Available";
		}
		if($lname == ""){
			$lname = "Not Available";
		}
		if($email == ""){
			$email = "Not Available";
		}
		if($address == ""){
			$address = "Not Available";	
		}
		if($created == ""){
			$created = "Not Available";
		}
		
	}
	
	$tname = "N/A";
	$tpan = "N/A";
	$tbank = "N/A";
	$tadd = "N/A";
	$tss = "N/A";
	$thead = "N/A";
	$tbac = "N/A";	

	$sql = "SELECT * FROM TRADERS WHERE USER_ID= '$USER_ID'";
	$result = oci_parse($conn,$sql);	
	oci_execute($result);
	while($row = oci_fetch_assoc($result)){
		$tname = $row['NAME'];
		$tpan = $row['PAN_NUMBER'];
		$tbank = $row['BANK'];
		$tadd = $row['MAILING_ADDR'];
		$tss = $row['SOCIAL_SECURITY'];
		$thead = $row['TRADER_HEAD'];
		$tbac = $row['BANK_ACC_NUM'];		
	}



?>
<?php include('../includes/backend/head.php');?>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <?php include('./includes/nav.php'); ?>
    <!-- /.sidebar -->
  </aside>
  
  
   <div class="content-wrapper" >
    <!-- Main content -->
    <section class="content" >
      <div class="row">
        <!-- left column -->
        <div class="col-md-6" style="background-color:#ffffff;">
          <!-- general form elements -->
                      <div class="panel-heading p-h-md">
                <h3 class="page-header p-b-md m-b-xs">View Profile<span class='label label-info pull-right'>Trader Account</span></h3>
            </div>
            <div class="panel-body" style="background-color:#ffffff;">
                <div class="row">
                    
                    <div class="col-md-10">
                        <table class="table table-striped table-hover table-bordered">
                            <caption><h4>Basic Information</h4></caption>
                            <tbody>
                                <tr>
                                    <td width="40%">First Name</td>
                                    <td><?php echo $fname; ?></td>
                                </tr>
                                <tr>
                                    <td>Last Name</td>
                                    <td><?php echo $lname; ?></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><?php echo $email; ?></td>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td><?php echo $fname; ?></td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td><?php echo $address; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>            
                <div class="row">                    
                    <div class="col-md-10">
                        <table class="table table-striped table-hover table-bordered">
                            <caption><h4>Trader Information</h4></caption>
                            <tbody>
                                    <tr>
                                        <td width="40%">Name</td>
                                        <td><?php echo $tname; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Pan Number</td>
                                        <td><?php echo $tpan; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Bank</td>
                                        <td><?php echo $tbank; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Bank Account Number</td>
                                        <td><?php echo $tadd; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Mailing Address</td>
                                        <td><?php echo $tadd; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Socail Security</td>
                                        <td><?php echo $tss; ?></td>
                                    </tr>
									<tr>
                                        <td>Trader Head</td>
                                        <td><?php echo $thead; ?></td>
                                    </tr>
									<tr>
                                        <td>Bank Account Number</td>
                                        <td><?php echo $tbac; ?></td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>	
				
            </div>
			<div class="col-md-2 text-center">                        
					<div>
						<a href="edituser.php" class="btn btn-default m-t-md">
							<i class="fa fa-pencil fa-fw"></i> Edit Profile
						</a>
					</div>
			</div><br><br><br>
			<div class="col-md-2 text-center"></div>
          </div>
          </div>
	</section>
    <!-- /.content -->
  </div>

  <footer class="main-footer">
    <strong>Copyright &copy; 2023 <a href="">ShopHub</a>.</strong> All rights
    reserved.
  </footer>  

<!-- ./wrapper -->
<?php include('./includes/script.php'); ?>
</body>
</html>
