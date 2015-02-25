<?php
include 'db_connect.php';
session_start();
ob_start();
//defining error variable
$email_err = "  ";
$db_err = "  ";

if(isset($_POST['log_in'])){

	$user_name = $_POST['user_name'];
	$password = md5($_POST['password']);

  //query for checking username and password
  $check_username_sql = "SELECT * FROM `user_master` WHERE (`user_email` = '".$user_name."' OR  `mobile_no` = '".$user_name."') AND `password` = '".$password."'";
  if($check_username_res = mysqli_query($con , $check_username_sql)){
    //mysqli_query works
    
    //checking for query result's no of row is equal to one
    if(mysqli_num_rows($check_username_res) == 1){
      $_SESSION['user_name'] = $user_name;
        header("location: profile.php");
    }
    else{
      $email_err = "Invalid user name/password combination.<br>";
    }
  }
  else{
    //when mysqli_query foctions fails
    $db_err = "Error in checking username in database.";
  }

}
?>

<html>
<head>
<title>Log In</title>
<link rel="stylesheet" href="css/bootstrap.min.css">

</head>
<body>
<?php
include 'header.php';
?>
<div class="container">
  <form class="form-horizontal" action="#" method="post">
    <fieldset>
      
      <!-- Form Name -->
      <legend>Log In</legend>
      
      <!--display error-->
      <?php echo $db_err; ?>

      <!-- Text input-->
      <div class="row">
        <div class="col-md-4">
          <label class="control-label" for="user_name">User Name</label>
          <input id="user_name" name="user_name" type="text" placeholder="Email Address or Mobile Number" class="form-control" required>
        </div>
        <div class="col-md-8"> </div>
      </div>
      <br>
      
     <!-- Password input-->
     <div class="row">
        <div class="col-md-4">
          <label class="control-label" for="password">Password</label>
          <input id="password" name="password" type="password" placeholder="Password" class="form-control" required>
        </div>
        <div class="col-md-8"> </div>
      </div>
      
      <!--display error-->
      <?php echo $email_err; ?>

      <br>
      
       <!-- Button -->
      <input type="hidden" name="log_in" value="log_in">
      <button type="submit" class="btn btn-primary">Log In</button><br><br>
    </fieldset>
  </form>
</div>


<script src="js/jquery.js"></script> 
<script src="js/bootstrap.min.js"></script>

</body>
</html>