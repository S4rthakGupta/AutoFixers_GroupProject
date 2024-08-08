<?php
//include connection file 
include "auto_fixers.php";

$itemName = $_POST['model'];
$brand = $_POST['brand'];
$description = $_POST['description'];
$price = $_POST['price'];

$sql = "INSERT INTO Items (ItemName, Brand, ItemDescription, Price) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssd", $itemName, $brand, $description, $price);

if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();

$conn->close();
?>