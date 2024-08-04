<?php
//include connection file 
include "dbconnect.php";

$itemID = $_POST['hdnId'];
$name = $_POST['editname'];
$brand = $_POST['editbrand'];
$description = $_POST['editdescription'];
$price = $_POST['editprice'];

// Prepare and bind
$stmt = $conn->prepare("UPDATE Parts SET name=?, price=?, stock=? WHERE ItemID=?");
$stmt->bind_param("sssdi", $name, $brand, $description, $price, $itemID);

// Execute the query
if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $stmt->error;
}

// Close statement and connection
$stmt->close();


$conn->close();
