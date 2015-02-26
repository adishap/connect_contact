<?php
include 'db_connect.php';
session_start();
ob_start();

//defining error variable
$email_err = "  ";
$pwd_err = " ";

if(isset($_POST['register'])){

	$first_name = $_POST['first_name'];
	$middle_name = $_POST['middle_name'];
	$last_name = $_POST['last_name'];
	$gender = $_POST['sex'];
	$dob = date("Y-m-d",strtotime($_POST['dob']));
	$mobile_no = $_POST['mobile_no'];
	$user_email = $_POST['email_id'];
	$city = $_POST['city'];	
	$new_password = $_POST['new_password'];
	$entered_password = $_POST['entered_password'];

	//checks new password and reentered password
	if($new_password == $entered_password){
		$password = md5($new_password);//md5()conversion of password
	
		//checking for email_id and phone no are unique or not 
		$check_email_query = "SELECT * FROM user_master WHERE `user_email` = '".$user_email."' OR `mobile_no` = '".$mobile_no."'";
		if($check_email_result = mysqli_query($con,$check_email_query)){
			$query_num_rows = mysqli_num_rows($check_email_result);
			if($query_num_rows == 0){//if no of rows is 0 then register the user
				
				$insert_query = "INSERT INTO `user_master`(`user_email`, `password`, `first_name`, `middle_name`, `last_name`, `gender`, `date_of_birth`, `loc_city`, `mobile_no`) VALUES ('".$user_email."','".$password."','".$first_name."','".$middle_name."','".$last_name."','".$gender."','".$dob."','".$city."','".$mobile_no."')";
				if($insert_result = mysqli_query($con , $insert_query)){
					//if insert query executed echo successful
					echo "<script>alert('User registered successfully.')</script>";
				} 
				else{
					$db_error = "Oops!! Error occured in inserting in database.";
				}

			}
			else{
				$email_err = "Email id or mobile number already exists.";
			}
		}
		else{
			//if check email query fails
			$db_error = "Oops!! Error in checking entries in database.";
		}
	}
	else{
		$pwd_err = "Passwords don't match.";
	}
}
?>
<html>
<meta charset="utf-8">
<head>
<title>Register</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script src="js/bootstrap.min.js"></script>

 <script>
$(function() {
$( ".datepicker" ).datepicker({
changeMonth: true,
changeYear: true
});
 
});
</script>

</head>
<body>
<?php
include 'header.php';
?>
<div class="container">
  <form action="#" method="post">
	<!-- Form Name -->
      <legend>Register</legend>
      <?php
	if(trim($db_error)!= ''){
		echo $db_error;
	}
	?>

	<div class="row">
	<!--Form input for name-->
	<label style="margin-left:20px">Name </label><br>

	<!--Input for first_name-->
	<div class="col-sm-3"  >
	<input name="first_name" type="text" placeholder="First Name"required />
	</div>
	
	<!--Input for middle_nume-->
	<div class="col-sm-3"  >
	<input name="middle_name" type="text" placeholder="Middle Name" />
	</div>

	<!--Input for last_name-->
	<div class="col-sm-3"  >
	<input name="last_name" type="text" placeholder="Last Name" required />
	</div>

	<div class="col-sm-3"  >
	<!--intentionally blank-->
	</div>

	</div >
	<br>

	<!--Input for gender-->
	<label>Gender</label><br>
	<div class="row">

	<!--Input for male-->
	<div class="col-sm-2"  >
	<input type="radio" name="sex" value="male" checked>Male
	</div>
	
	<!--Input for female-->
	<div class="col-sm-2"  >
	<input type="radio" name="sex" value="female">Female
	</div>

	<!--Input for other-->
	<div class="col-sm-2"  >
	<input type="radio" name="sex" value="other">other
	</div>
	
	<div class="col-sm-6"  >
	<!--intentionally blank-->
	</div>
	
	</div>
	<br>

	<!--Input for date of birth-->
	<label>Date of Birth</label><br>
    <div class="row">
    
    <div class="col-md-3">
    <input type="text" name="dob" class="datepicker">
    </div>
    
    <div class="col-md-9">
    <!--Intentionally Blank -->
    </div>

    </div>
	<br>

	<div class="row">

	<!--Input for Mobile No-->	
	<div class="col-sm-4">
	<label>Mobile Number</label><br>
	<input name="mobile_no" type="text" placeholder="+91-9876543210"required />
	</div>

	<!--Input for Email id-->
	<div class="col-sm-8">
	<label>Email</label><br>
	<input name="email_id" type="email" placeholder="abc@de.f"required /><br>
	</div>
	<?php
	if(trim($email_err)!= ''){
		echo $email_err;
	}
	?>

	</div>
	<br>

	<!--Input for Local City-->
	<label>Current City</label><br>
	<input name="city" type="text" placeholder="Mumbai" required />
	<br>
	<br>

	<div class="row">

	<div class="col-md-3">
	<!--Input for Password-->
	<label>Choose Password</label><br>
	<input type="password" name="new_password" placeholder="Password" required>
	<br>
	</div>
	
	<div class="col-md-3">
	<!--Input for Re-entered Password-->
	<label>Re-enter Password</label><br>
	<input type="password" name="entered_password" placeholder="Re-enter Password" required>
	<br>
	</div>
	<div class="col-md-6">
	<!--Intentionally Blank-->
	</div>
 	
 	<?php
	//echo error occured
	if(trim($pwd_err)!= ''){
		echo $pwd_err;
	}
 	?>
 	</div>
	<br>

	<!--Submit button-->
    <input type="hidden" name="register" value="register">
	<button type="submit" class="btn btn-primary" >Register</button><br>
	
	Already registered?
	<a href="log_in.php">Sign in</a> now.
	
	</form>
</div>


</body>
</html>