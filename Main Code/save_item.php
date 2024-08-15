<?php

// Include the connection file 
include "db_connect.php";



$partName = $_POST['model'];
$brand = $_POST['brand'];
$description = $_POST['description'];
$price = $_POST['price'];

$sql = "INSERT INTO Parts (PartName, Brand, PartDescription, Price) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssd", $partName, $brand, $description, $price);

if ($stmt->execute()) {
    header("Location: interface/index.php"); // Replace "success.php" with your desired page
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();

$conn->close();
?>