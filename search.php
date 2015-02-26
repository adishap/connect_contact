<?php

//if user is not logged in
if(!isset($_SESSION['user_name']) || (trim($_SESSION['user_name']) == '')) {
 	header('location: log_in.php');
}
else{

include 'db_connect.php';

?>

<html>
<head>
<title>Search</title>
<link rel="stylesheet" href="css/bootstrap.min.css">

</head>
<body>
<?php
include 'header.php';
?>
<div class="container">
  
<div class="row">

  <div class="col-md-3">
  <!--div for searching-->

  <!-- Search Form div -->
  <form action="#" method="post">
  
  <!--form name-->
  <legend>Search</legend>
   
   <!--Input for name-->
  <label>Name </label><br>
  <input name="name" type="text" placeholder="Mark" /><br />
  
  <!--Input for city-->
  <label>City</label><br>
  <input name="city" type="text" placeholder="New York" />
  <br>

  <!--Input for organisation-->
  <label>Organisation</label><br>
  <input name="organisation" type="text" placeholder="TCS" />
<br>
<br>
<input type="hidden" name="search" value="search">
<button type="submit" class="btn btn-primary">Search</button><br><br>
</form>

  </div>

  <div class="col-md-9">
   <!--div for showing result--> 

<?php
if(isset($_POST['search'])){
  $search_query = "SELECT * FROM `user_master` WHERE 1";

  if(!empty($_POST['name'])){
    $name = $_POST['name'];

    $search_query .= " AND (`first_name` LIKE '%".$name."%' OR `middle_name` LIKE '%".$name."%' OR `last_name` LIKE '%".$name."%')";
  }

  if(!empty($_POST['city'])){
    $city = $_POST['city'];

    $search_query .= " AND (`loc_city` = '".$city."')";
  }

  if(!empty($_POST['organisation'])){
    $organisation = $_POST['organisation'];

   $search_query .= " AND (`user_email` IN (SELECT `user_email` FROM `alum_professional_info` WHERE `organisation_name` LIKE '%".$organisation."%' ))";
  }


  if($search_result = mysqli_query($con , $search_query)){

    if(mysqli_num_rows($search_result) >0){
      echo "<table class='table'>
          <tr>
          <th>Name</th>
          <th>Date of Birth</th>
          <th>Local Address</th>
          <th>Email Address</th>
          <th>Mobile Number</th>
          </tr>
          ";
      while($row = mysqli_fetch_array($search_result)) {
        echo '<tr>'; 
        echo '<td><a href="profile.php?user_email='.$row['user_email'].'">'.$row['first_name']." ".$row['middle_name']." ".$row['last_name'].'</td>';
        echo '<td>'.$row['date_of_birth'].'</td>';
        echo '<td>'.$row['loc_starting_address']." ".$row['loc_city']." ".$row['loc_pincode']." ".$row['loc_state']." ".$row['loc_country']." ".$row['loc_country_code'].'</td>';
        echo '<td>'.$row['user_email'].'</td>';
        echo '<td>'.$row['mobile_no'].'</td>';
       }
       echo '</table>';
    }
    else{
    echo $search_error = "Sorry no results found.";
    }

  }
  else{
  echo $db_error = "Error in executing query.";
  }
  

}
?>

  </div>

</div>
</div>


<script src="js/jquery.js"></script> 
<script src="js/bootstrap.min.js"></script>

</body>
</html>
<?php
}
?>