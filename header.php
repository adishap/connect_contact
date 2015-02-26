
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">
       Connect Contacts
      </a>
    </div>

      <ul class="nav navbar-nav navbar-right">
        
        <?php

        //if user is not logged in
if(!isset($_SESSION['user_name']) || (trim($_SESSION['user_name']) == '')) {
      echo '<li><a href="register.php">Register</a></li>';
      echo '<li><a href="log_in.php">Log In</a></li>';
}
else{

        ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Profile<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
          <li><a href="profile.php">View Profile</a></li>
          <li><a href="update_profile.php">Update Profile</a></li>  
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Contacts<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
          <li><a href="search.php">Search Contact</a></li>
          <li><a href="wish.php">Wish Birthday</a></li>  
          </ul>
        </li>
        <li><a href="log_out.php">Log Out</a></li>
      <?php
    }
      ?>
      </ul>
    
  </div><!-- /.container-fluid -->
</nav>