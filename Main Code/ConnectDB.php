<?php
//session_start();

$host="localhost";
$username="root";
$pass="";
$db="auto_fixers";
 
$conn=mysqli_connect($host,$username,$pass,$db);
if(!$conn){
	die("Database connection error");
}
 
 
?>