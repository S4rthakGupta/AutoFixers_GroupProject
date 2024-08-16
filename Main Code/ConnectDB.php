<?php

// Database connectivity file
$host="localhost";
$username="root";
$pass="";
$db="Transformers_autofixers";

// Connect Database using above parameters
$conn=mysqli_connect($host,$username,$pass,$db);

// Display DB connectivity error
if(!$conn){
	die("Database connection error");
}
 
 
?>