<?php
$host = "localhost";
$username = "root";
$pass = "";
$db = "auto_fixers";

// Create connection
$conn = new mysqli($host, $username, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>