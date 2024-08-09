<?php
//include connection file 
include "dbconnect.php";



$itemID = $_POST['hdnId'];
$itemName = $_POST['editmodel'];
$brand = $_POST['editbrand'];
$description = $_POST['editdescription'];
$price = $_POST['editprice'];

// Prepare and bind
$stmt = $conn->prepare("UPDATE Items SET ItemName=?, Brand=?, ItemDescription=?, Price=? WHERE ItemID=?");
$stmt->bind_param("sssdi", $itemName, $brand, $description, $price, $itemID);

// Execute the query
if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $stmt->error;
}

// Close statement and connection
$stmt->close();


$conn->close();
