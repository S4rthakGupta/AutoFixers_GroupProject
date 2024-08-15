<?php

// Include the connection file 
include "db_connect.php";

$partName = $_POST['model'];
$description = $_POST['description'];
$price = $_POST['price'];

$sql = "INSERT INTO Parts (PartName, PartDescription, Price) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssd", $partName, $description, $price);

if ($stmt->execute()) {
    header("Location: UserInterface/index.php"); // Replace "success.php" with your desired page
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();

$conn->close();
?>