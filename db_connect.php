<?php
	$sql_host = 'localhost';
	$sql_user = 'root';
	$sql_pass = 'root';
	$err_msg = "Error occured in connecting database";
    $sql_db = 'personal_alum_db';
	
$con = mysqli_connect($sql_host, $sql_user, $sql_pass, $sql_db);
//echo "connected to db";
if(mysqli_connect_errno($con)){
echo 'Failed to connect to the database : '.mysqli_connect_error();
die();
}
