<?php

include 'db_connect.php';

session_start();
ob_start();

//if user is not logged in
if(!isset($_SESSION['user_name']) || (trim($_SESSION['user_name']) == '')) {
 	header('location: log_in.php');
}
else{
?>

<html>
<head>
<title>Profile</title>
<link rel="stylesheet" href="css/bootstrap.min.css">

</head>
<body>
<?php
include 'header.php';
?>
<!--contents-->
  <?php
  //setting user_email variable
  if(!empty($_GET['user_email'])){
    $user_email = mysql_real_escape_string(htmlentities($_GET['user_name']));
  }
  else{
    $user_email = $_SESSION['user_name'];
  }
  
  $user_email ;

  $query = "SELECT * FROM `user_master` WHERE `user_email` = '".$user_email."'";
  $result = mysqli_query($con , $query);
  if(mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_array($result)) {
  
      $name = $row['first_name']." ".$row['middle_name']." ".$row['last_name'];
      //conversion of date of birth in d-m-y format
      $date_of_birth = date("d-m-Y", strtotime($row['date_of_birth']));
      $local_address = $row['loc_starting_address']." ".$row['loc_city']." ".$row['loc_pincode']." ".$row['loc_state']." ".$row['loc_country']." ".$row['loc_country_code'];
      $per_address = $row['per_starting_address']." ".$row['per_city']." ".$row['per_pincode']." ".$row['per_state']." ".$row['per_country']." ".$row['per_country_code'];
      $mobile_no = $row['mobile_no'];
      $martial_status = $row['martial_status'];
      if($martial_status == "Married"){
        $date_of_anniversary = $row['date_of_anniversary'];
                //conversion of date of anniversary in d-m-y format
                $date_of_anniversary = date("d-m-Y", strtotime($date_of_anniversary));
            }
            $image_path = $row['image_path'];
      }
  }
?>
 <div class="container">
    <div class="row">

    <div class="col-md-2">
    <!--Space for image-->
    <?php
    if($image_path == NULL){
    ?>
        <img src="images/200x200.gif" alt="Display picture" height="200" width="200" border="1px">
    <?php
    }
    else{
    ?>
        <img src=<?php echo $image_path;?> alt="Display picture" height="200" width="200" border="1px">
    <?php
    }
    ?>
     </div>

     <div class="col-sm-1">
     <!--Intentionally Blank-->
     </div>

     <div class="col-md-9">
     <br>
     <!--Name-->
     <h2><?php echo $name; ?></h2>
     
     </div>

     </div>
     <br>
     
    <!--Date Of Birth-->
    <div class="row">
    <div class="col-sm-3">
    <strong>Date Of Birth</strong>
    </div>
    <div class="col-sm-9">
    <?php echo $date_of_birth; ?>
    </div>
    </div>
     <br>

    <!--Martial Status-->
  <div class="row">
    <div class="col-sm-3">
    <strong>Martial Status</strong>
    </div>
    <div class="col-sm-9">
    <?php echo $martial_status; ?>
    </div>
    </div>
    <?php 
    //if married echo DATE OF ANNIVERSARY
    if($martial_status == "Married"){
    ?>
    <div class="row">
    <div class="col-sm-3">
    <strong>Date Of Anniversary</strong>
    </div>
    <div class="col-sm-9">
    <?php echo $date_of_anniversary; ?>
    </div>
    </div>
    <br>
    <?php
    }
    ?>

    <h3>Contact Information</h3>

     <!--Mobile No-->
     <div class="row">
     <div class="col-sm-3">
     <strong>Mobile Number</strong>
     </div>
     <div class="col-sm-9">
     <?php echo $mobile_no;?>
     </div>
     </div>
     <br>

     <!--Email Address-->
     <div class="row">
     <div class="col-sm-3">
     <strong>Email Address</strong>
     </div>
     <div class="col-sm-9">
     <?php echo $user_email;?>
     </div>
     </div>
     <br>
    

     <!--Local Address-->
     <div class="row">
     <div class="col-sm-3">
     <strong>Local Address</strong>
     </div>
     <div class="col-sm-9">
     <?php echo $local_address;?>
     </div>
     </div>
     <br>
     
     <!--Permanent Address-->
     <div class="row">
     <div class="col-sm-3">
     <strong>Permanent Address</strong>
     </div>
     <div class="col-sm-9">
     <?php echo $per_address;?>
     </div>
     </div>
     <br>

     <!--ProfessionalInformation-->

     <?php
     $query = "SELECT * FROM `alum_pofessional_info` WHERE `user_email` = '$user_email'";
   $result = mysqli_query($con , $query);
   if(mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_array($result)) {
      $org_name = $row['organisation_name'];
      $job_title = $row['job_title'];
      $org_address = $row['starting_address']." ".$row['city']." ".$row['pincode']." ".$row['state']." ".$row['country'];
      if($row['self_employed'] == 1){
        $self_employed = "Yes";
      }
      else{
        $self_employed = "No";
      }
    }
   ?>

     <h3>Professional Information</h3>

   <!--Company Name-->
     <div class="row">
     <div class="col-sm-3">
     <strong>Works In </strong>
     </div>
     <div class="col-sm-9">
     <?php echo $org_name;?>
     </div>
     </div>
     <br>

   <!--Job Title-->
     <div class="row">
     <div class="col-sm-3">
     <strong>Works As</strong>
     </div>
     <div class="col-sm-9">
     <?php echo $job_title; ?>
     </div>
     </div>
     <br>

     <!--Organisation Address-->
     <div class="row">
     <div class="col-sm-3">
     <strong>Organisation Address</strong>
     </div>
     <div class="col-sm-9">
     <?php echo $org_address; ?>
     </div>
     </div>
     <br>

     <!--business man-->
     <div class="row">
     <div class="col-sm-3">
     <strong>Owns A Business</strong>
     </div>
     <div class="col-sm-9">
     <?php echo $self_employed;?>
     </div>
     </div>
     <br>

   <?php
   }
     ?>

</div>


<script src="js/jquery.js"></script> 
<script src="js/bootstrap.min.js"></script>

</body>
</html>

<?php
}
?>