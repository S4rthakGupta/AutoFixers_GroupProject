<!-- 
    Shakila Samaradiwakara 8886070 
    Sarthak Gupta 8971797 
    Abhishek Chachad 8971294     
-->

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