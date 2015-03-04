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
<title>Update Profile</title>
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

$user_email = $_SESSION['user_name'];
?>
<!--contents-->

 <div class="container">
  <div id="content">
<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
<li class="active"><a href="#tab1" data-toggle="tab">Personnal Information</a></li>
<li><a href="#tab2" data-toggle="tab">Martial Status</a></li>
<li><a href="#tab3" data-toggle="tab">Address</a></li>
<li><a href="#tab4" data-toggle="tab">Professional Information</a></li>
<li><a href="#tab5" data-toggle="tab">Change Password</a></li>
</ul>
<div id="my-tab-content" class="tab-content">

<!--Form for personal info -->
<div class="tab-pane active" id="tab1">

<!--name form-->
    <form action="#" method="post">
    <br>
    <legend>Update Name</legend>

    <!--input first name disabled as first name cannot change-->
    <input name="first_name" type="text" placeholder="First Name" disabled /><br><br>
    <!--input middle name-->
    <input name="middle_name" type="text" placeholder="Middle Name" /><br><br>
    <!--input last Name-->
    <input name="last_name" type="text" placeholder="Last Name" required /><br>
    <br>

    <!--Submit Button-->
    <input type="hidden" name="update_name" value="update_name">
    <button type="submit" class="btn btn-primary" >Update Name</button><br><br>
    </form>
    
    <form action="#" method="post" enctype="multipart/form-data">
    
    <legend>Change Display Picture:</legend>
    
    <input type="file" name="fileToUpload" id="fileToUpload">
    <br>
    
    <!--Submit Button-->
    <input type="hidden" name="upload_image" value="Upload Image">
    <button type="submit" class="btn btn-primary" >Upload Image</button><br><br>
    
    </form>

    <?php
    //backend for updating name

      if(isset($_POST['update_name'])){
        
        if (!empty($_POST['middle_name']) || !empty($_POST['last_name'])) {
        
          $middle_name = $_POST['middle_name'];
          $last_name = $_POST['last_name']; 

          $name_query = "UPDATE `user_master` SET`middle_name`='".$middle_name."',`last_name`='".$last_name."' WHERE `user_email` ='".$user_email."'";
          if($name_result = mysqli_query($con,$name_query)){
            echo "<script>alert('Updation Successful.')</script>";
          }
          else{
            echo "<script>alert('Error in updating name.')</script>";
          }
        }
        else{
          echo 'Please fill middle name or last name.';
        }
      }

    //backend for updating image

    if(isset($_POST['upload_image'])){

      $target_dir = "images/";
      $uploadOk = 1;
      $imageFileType = pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION);
      //$target_file = $target_dir.$user_email.".".$imageFileType;
      $target_file = $target_dir."red.".$imageFileType;
    
      //checks file size
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
        $uploadOk = 1;
      }
      else {
        echo "<script>alert('File is not an image.')</script>";
        $uploadOk = 0;
      }   

      // Check if file already exists
      if (file_exists($target_file)) {
        //delete image
        unlink($target_file);
      }

      // Check file size
      if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "<script>alert('Sorry, your file is too large.')</script>";
        $uploadOk = 0;
      }

      // Allow certain file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
        $uploadOk = 0;
      }
      echo $target_file;
      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
        echo "<script>alert('Sorry, your file was not uploaded.')</script>";
        // if everything is ok, try to upload file
      }
      else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

          $image_update_query = "UPDATE `user_master` SET `image_path`='".$target_file."' WHERE `user_email` ='".$user_email."'";
          if($image_update_result = mysqli_query($con,$image_update_query)){
          	echo "<script>alert('The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.')</script>";
          }
          
        }
        else {
        echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
        }
      }
      
    }
    ?> 


</div>

<div class="tab-pane" id="tab2">

<br>
<!--Update martial status-->
    <form action="#" method="post" style="text-align:left;margin-left:5%">
    <!-- Form Name -->
    <legend>Update Martial Status</legend>

    <!-- Multiple Radios -->
    <!--Married Radio-->
    <input name="martial_status" value="Married" checked="checked" type="radio">
    Married
    <br>
    <!--Unmarried Radio-->
    <input name="martial_status" value="Unmarried" type="radio">
    Unmarried
    <br>
    <br>

    <!--Input for date of anniversary-->
  <label>Date of Anniversary</label><br>
    <input type="text" name="date_of_anniversary" class="datepicker">
    
  <br>
    <!-- Button -->
    <input type="hidden" name="update_martial_status" value="update_martial_status">
    <button type="submit" class="btn btn-primary" >Update</button><br><br>

    </form>
    <?php
    //backend for name

      if(isset($_POST['update_martial_status'])){
        
        if (!empty($_POST['martial_status']) || !empty($_POST['date_of_anniversary'])) {
        
          $martial_status = $_POST['martial_status'];
          $date_of_anniversary = date("Y-m-d",strtotime($_POST['date_of_anniversary']));

          $martial_status_query = "UPDATE `user_master` SET `martial_status`='".$martial_status."',`date_of_anniversary`='".$date_of_anniversary."' WHERE `user_email` ='".$user_email."'";
          if($martial_status_result = mysqli_query($con,$martial_status_query)){
            echo "<script>alert('Updation Successful.')</script>";
          }
          else{
            echo "<script>alert('Error in updating martial status.')</script>";
          }
        }
      }
    ?> 

</div>

<div class="tab-pane" id="tab3">
<br>
<form action="#" method="post">
    <legend>Change Permanent Address</legend>
    
    <!--input for permanent starting address-->
    <label>Starting Address</label><br>
    <input class="form-control" id="per_starting_address" name="per_starting_address">
  
    <table class="table-condensed">
    
    <tr>
    <!--input for permanent city-->
    <td><label >City </label></td> 
    <td><input id="per_city" name="per_city" placeholder="Indore" required type="text"></td>
    </tr>
    
    <tr>
    <!--input for permanent state-->
    <td><label>State</label></td>  
    <td><input id="per_state" name="per_state" placeholder="MP" required type="text"></td>
    </tr>
 
    <tr>
    <!--input for permanent country-->
    <td><label>Country</label></td>  
    <td><input id="per_country" name="per_country" placeholder="India" required type="text"></td>
    </tr>

    <tr>
    <!--input for permanent address pincode-->
    <td><label>Pincode</label></td>
    <td><input id="per_pincode" name="per_pincode" placeholder="452010" type="text"></td>
    </tr>
    
    <tr>
    <!-- Submit Button -->
    <td>
    <input type="hidden" name="update_per_address" value="update_per_address">
    <button type="submit" class="btn btn-primary" >Update Permanent Address</button></td>
    </tr>

    </table>
    </form>
    
    <?php
    //backend for permanent Address

      if(isset($_POST['update_per_address'])){
        $per_starting_address = $_POST['per_starting_address'];
        $per_city = $_POST['per_city']; 
        $per_state = $_POST['per_state'];
        $per_country = $_POST['per_country'];
        $per_pincode = $_POST['per_pincode'];


        $per_address_query = "UPDATE `user_master` SET  `per_country`='".$per_country."',`per_state`='".$per_state."',`per_city`='".$per_city."',`per_starting_address`='".$per_starting_address."',`per_pincode`='".$per_pincode."' WHERE `user_email` ='".$user_email."'";
        if($per_address_result = mysqli_query($con,$per_address_query)){
          echo "<script>alert('Updation Successful.')</script>";
        }
        else{
          echo "<script>alert('Error in updating permanent Address.')</script>";
        }
      }
    ?> 


    <!-- Form Name -->
    <legend>Change Local Address</legend>

    <!--input for permanent address pincode-->
    <label>Starting Address</label><br>
    <input class="form-control" id="local_starting_address" name="local_starting_address">
    <table class="table-condensed">
    
    <tr>
    <!--input for local address city-->
    <td><label >City </label></td> 
    <td><input id="local_city" name="local_city"   placeholder="Indore" required  type="text"></td>
    </tr>
  
    <tr>
    <!--input for local address state-->
    <td><label>State</label></td>  
    <td><input id="local_state" name="local_state" placeholder="MP" required type="text"></td>
    </tr>
 
    <tr>
    <!--input for local address country-->
    <td><label>Country</label></td>  
    <td><input id="local_country" name="local_country" placeholder="India" required type="text"></td>
    </tr>

    <tr>
    <!--input for local address pincode-->
    <td><label>Pincode</label></td>
    <td><input id="local_pincode" name="local_pincode" placeholder="452010" type="text"></td>
    </tr>
    
    <tr>
    <!-- Submit Button -->
    <td>
    <input type="hidden" name="update_local_address" value="update_local_address">
    <button type="submit" class="btn btn-primary" >Update Local Address</button></td>
    </tr>

    </table>
    </form>

    <?php
    //backend for local Address

      if(isset($_POST['update_local_address'])){
        $loc_starting_address = $_POST['local_starting_address'];
        $loc_city = $_POST['local_city']; 
        $loc_state = $_POST['local_state'];
        $loc_country = $_POST['local_country'];
        $loc_pincode = $_POST['local_pincode'];


        $loc_address_query = "UPDATE `user_master` SET  `loc_country`='".$loc_country."',`loc_state`='".$loc_state."',`loc_city`='".$loc_city."',`loc_starting_address`='".$loc_starting_address."',`loc_pincode`='".$loc_pincode."' WHERE `user_email` ='".$user_email."'";
        if($loc_address_result = mysqli_query($con,$loc_address_query)){
          echo "<script>alert('Updation Successful.')</script>";
        }
        else{
          echo "<script>alert('Error in updating Local Address.')</script>";
        }
      }
    ?> 


</div>

<div class="tab-pane" id="tab4">
<br>
<form action="#" method="post">
    <!-- Form Name -->
    <legend>Update Professional Information</legend>
    <!-- input company Name -->  
    <label>Company Name</label><br>
    <input id="org_name" name="org_name" placeholder="TCS" required type="text">
    <br>
    <br>

    <!-- input job title -->
    <label >Job Title</label><br>
    <input id="job_title" name="job_title" placeholder="CEO" required type="text">
    <br>
    <br>

    <!-- input office email address -->
    <label >Office Email Address</label><br>
    <input id="office_email" name="office_email" placeholder="mark@tcs.in" type="email">
    <br>
    <br>

    <!-- Organisation Address-->
    <label>Office Address</label><br>
    <table class="table-condensed">
    
    <tr>
    <!--input for organisation address starting address-->
    <td><label >Starting Address </label></td> 
    <td><input id="org_starting_address" name="org_starting_address" placeholder="101,Ahinsa Tower" type="text"></td>
    </tr>

    <tr>
    <!--input for organisation address city-->
    <td><label >City </label></td> 
    <td><input id="org_city" name="org_city" placeholder="Indore" type="text"></td>
    </tr>
  
    <tr>
    <!--input for local address pincode-->
    <td><label>Pincode</label></td>
    <td><input id="local_pincode" name="local_pincode" placeholder="452010" type="text"></td>
    </tr>
    
    <tr>
    <!--input for organisation address state-->
    <td><label>State</label></td>  
    <td><input id="org_state" name="org_state" placeholder="MP" type="text"></td>
    </tr>
 
    <tr>
    <!--input for local address country-->
    <td><label>Country</label></td>  
    <td><input id="org_country" name="org_country" placeholder="India" type="text"></td>
    </tr>

    </table>
    <br>
    <input type="checkbox" name="business_owner" value="1" />
    <label>Owns a business</label>

    <br>
    
    <!--Submit Button-->
    <input type="hidden" name="update_professional_info" value="update_professional_info">
    <button type="submit" class="btn btn-primary" >Update Professional Information</button><br>
    </form>
    <?php
    //backend code
    if(isset($_POST['update_professional_info'])){
      
      $org_name = $_POST['org_name'];
      $job_title = $_POST['job_title'];
      $org_starting_address = $_POST['org_starting_address'];
      $org_city = $_POST['org_city']; 
      $org_state = $_POST['org_state'];
      $org_country = $_POST['org_country'];
      $org_pincode = $_POST['org_pincode'];
      $org_email = $_POST['office_email'];
      if(isset($_POST['business_owner'])&& ($_POST['business_owner'] == 1)){
        $business_owner = 1;
      }
      else{
        $business_owner = 0;
      }

      //check if info already exists or not
      $check_user_query = "SELECT `user_email` FROM alum_professional_info WHERE `user_email` = '".$user_email."'";
      $result = mysqli_query($con , $check_user_query);
      if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result)) {
          echo $row['user_email'];
          //if exists then we will apply update query
          $professional_update_query = "UPDATE `alum_professional_info` SET `organisation_name`='".$org_name."',`job_title`='".$job_title."', `country`='".$org_country."',`state`='".$org_state."',`city`='".$org_city."',`starting_address`='".$org_starting_address."',`office_email_id`='".$org_email."',`self_employed`='".$business_owner."' WHERE `user_email` ='".$user_email."'";
          if($update_result = mysqli_query($con , $professional_update_query)){
            echo "<script>alert('Updation Successful.')</script>";
          }
          else{
            echo "<script>alert('Opps!! Error in updating professional information in database.')</script>";
          }
        }
      }
      else{
        //if information doesn't exists then we will apply insert query
        $professional_update_query = "INSERT INTO `alum_professional_info` (`user_email`, `organisation_name`, `job_title`, `country`, `state`, `city`, `starting_address`, `office_email_id`, `self_employed`) VALUES ('".$user_email."','".$org_name."','".$job_title."','".$org_country."','".$org_state."','".$org_city."','".$org_starting_address."','".$org_email."','".$self_employed."')";
        if($update_result = mysqli_query($con , $professional_update_query)){
         echo "<script>alert('Updation Successful.')</script>";
        }
        else{
         echo "<script>alert('Opps!! Error in updating professional information in database.')</script>";
        }
      }
    } 
    ?>


</div>

<div class="tab-pane" id="tab5">
<br>
<!--Update password -->
    <form action="#" method="post">
    <!-- Form Name -->
    <legend>Change Password:</legend>
    
    <!-- input present password -->  
    <label>Present Password</label><br>
    <input id="old_password" name="old_password"  required placeholder="Password" type="password">
    <br>
    <br>

    <!-- input new password -->
    <label >New Password</label><br>
    <input id="new_password" name="new_password" required  placeholder="New Password" type="password">
    <br>
    <br>

    <!-- Password input-->
    <label>Re-enter Password</label><br>
    <input id="re_password" name="re_password" required placeholder="Re-enter Password" type="password">
    <br>
    <br>

    <!--Submit Button-->
    <input type="hidden" name="update_password" value="update_password">
    <button type="submit" class="btn btn-primary" >Update Password</button><br>

    </form>

    <?php
    //backend for password update

      if(isset($_POST['update_password'])){
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password']; 
        $re_password = $_POST['re_password'];

        //first check new password and reentered passwords are same
        if($new_password == $re_password){
          //convert new password into md5
          $new_password = md5($new_password);
          //taking old password form database
          $old_password_query = "SELECT `password` FROM `user_master` WHERE `user_email` = '".$user_email."'";
          $result = mysqli_query($con , $old_password_query);
          if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_array($result)) {
              $db_password = $row['password'];
              //converting entered password into md5() form
              $old_password = md5($old_password);

              //if database password and old password match
              if($db_password == $old_password){
                //query for updation
                $password_update_query = "UPDATE `user_master` SET `password` = '".$new_password."'  WHERE `user_email` ='".$user_email."'";
                if($password_update_result = mysqli_query($con,$password_update_query)){
                  echo "<script>alert('Updation Successful.')</script>";
                }
                else{
                  echo "<script>alert('Error in updating password in database.')</script>";
                }
              }
              else{
                echo "<script>alert('Please enter correct password.')</script>";
              }
            }
          }
        }
        else{
          echo "<script>alert('New password and re entered password don't match.')</script>";
        }
      }
    ?>


</div>
</div>
</div>
 
 
<script type="text/javascript">
jQuery(document).ready(function ($) {
$('#tabs').tab();
});
</script> 
</div>

</body>
</html>

<?php
}
?>