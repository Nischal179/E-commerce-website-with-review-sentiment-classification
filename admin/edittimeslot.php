<?php
	session_start();
	if(isset($_SESSION['USER_ID'])){
	$USER_ID = $_SESSION['USER_ID'];	
	}else{
		header('location:../login.php');
	}
include '../core/connection.php';
if(isset($_GET['sid'])){
	$error_count=0;
	$sid = $_GET['sid'];
	$detail = "SELECT * FROM TIME_SLOT WHERE TIME_SLOT_ID = $sid";
	$detailqry = oci_parse($conn, $detail);
	oci_execute($detailqry);
	while($row = oci_fetch_assoc($detailqry)){
		$txtStart = $row['START_TIME'];
		$txtEnd = $row['END_TIME'];
				
	}
}
if(isset($_POST['cancel'])){
	header('Location: timeslot.php');
}
if(isset($_POST['submit'])){
	$error_count=0;
	If(!empty($_POST["start"])){
	$start = $_POST["start"];
		
	}else{
		$error_count++;
	}
	
	If(!empty($_POST["end"])){
	$end = $_POST["end"];
		
	}else{
		$error_count++;
	}
	if ($error_count == 0){
		$detail = "UPDATE TIME_SLOT SET START_TIME = '$start', END_TIME='$end' WHERE TIME_SLOT_ID = $sid";
		$detailqry = oci_parse($conn, $detail);		
		$ociExecute = oci_execute($detailqry);
		if(!$ociExecute){
			echo "<script>alert('Oci Execute Error');window.location.href='timeslot.php';</script>";
		}else{
			echo "<script>alert('You have sucessfully Edited a Time Slot.');window.location.href='timeslot.php';</script>";
		}
		
		
	}		
}
?>


<!DOCTYPE html>
<?php 
	include('includes/head.php');
?>
	
<body class="hold-transition">
<style>
#login {
    border: 0px solid;
    padding: 10px;
    box-shadow: 0 0 5px #888888;
	background-color: #ffffff;
}
#logo {
	width: 100%;
	background-color: #ffffff;
}

body {
    background-color: #f9f9f9;
}
</style>
<div class="login-box" id="login">  
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"><font size="5">Edit Time Slot</font></p>

    <form action="" method="post">
      <div class="form-group has-feedback">
		<?php 
			$days = array(
				0 => 'Sunday',
				1 => 'Monday',
				2 => 'Tuesday',
				3 => 'Wednesday',
				4 => 'Thursday',
				5 => 'Friday',
				6 => 'Saturday'
				
			);				
			
			$detail="SELECT * FROM TIME_SLOT WHERE TIME_SLOT_ID=$sid";
			$detailqry = oci_parse($conn, $detail);
			oci_execute($detailqry);
			while($row = oci_fetch_array($detailqry)){
				$intDay = $row['DAY'];
				$varDay = $days[$intDay];
			}
		?>
		<label>Day</label>        
        <span class="form-control-feedback"></span>
		<input type="text" class="form-control" placeholder="Category Name" value="<?php echo $varDay?>" name="start" disabled>
      </div>
	  <div class="form-group has-feedback">
		<label>Start Time</label>
        <input type="text" class="form-control" placeholder="Category Name" value="<?php echo $txtStart?>" name="start">
        <span class="form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
		<label>End Time</label>
        <input type="text" class="form-control" placeholder="Description" value="<?php echo $txtEnd?>" name="end">
        <span class="form-control-feedback"></span>
      </div>
	  <br>
      <div class="row">        
        <!-- /.col -->
        <div class="col-xs-6">
          <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat">Save Time Slot</button>
        </div>
		<div class="col-xs-6">			
			<button type="submit" name="cancel" class="btn btn-primary btn-block btn-flat">Cancel</button>			
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

</script>
<?php include('includes/script.php'); ?>
</body>
</html>