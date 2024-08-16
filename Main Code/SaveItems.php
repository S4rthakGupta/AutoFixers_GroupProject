<?php

// Include the connection file 
include "ConnectDB.php";



$partName = $_POST['model'];
$trademark = $_POST['trademark'];
$description = $_POST['description'];
$price = $_POST['price'];

$sql = "INSERT INTO Parts (PartName, Trademark, PartDescription, Price) VALUES (?, ?, ?, ?)";
$state = $conn->prepare($sql);
$state->bind_param("sssd", $partName, $trademark, $description, $price);

if ($state->execute()) {
    header("Location: interface/index.php"); // Replace "success.php" with your desired page
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$state->close();

$conn->close();
?>