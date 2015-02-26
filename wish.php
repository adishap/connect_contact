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
<title>Wish Birthday</title>
<link rel="stylesheet" href="css/bootstrap.min.css">

</head>
<body>
<?php
include 'header.php';
?>
<!--contents-->

 <div class="container">
  <legend>Say Happy Birthday!!</legend>
    <?php
  
  $date = date("Y-m-d");

  $query = "SELECT * FROM `user_master` WHERE `date_of_birth` = '".$date."'";
  $result = mysqli_query($con , $query);
  if(mysqli_num_rows($result)>0){
    echo '<ul>';
    while($row = mysqli_fetch_array($result)) {
  
      $name = $row['first_name']." ".$row['middle_name']." ".$row['last_name'];
      
      echo '<li>'.$name.'<li>';
    }
    echo '</ul>';
    ?>

<form action="#" method="post">

<textarea placeholder="Email birthday wishes.Type a message..." cols="50" rows="3"></textarea><br><br>

<!-- Button -->
      <input type="hidden" name="wish" value="wish">
      <button type="submit" class="btn btn-primary">Send</button><br><br>

</form>

    <?php
  }
  else{
    echo "No birthday today...!!!";
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