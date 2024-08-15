<?php

// Include the connection file 
include "db_connect.php";




$partID = $_POST['hdnId'];
$partName = $_POST['editmodel'];
$brand = $_POST['editbrand'];
$description = $_POST['editdescription'];
$price = $_POST['editprice'];

// Prepare and bind
$stmt = $conn->prepare("UPDATE Parts SET PartName=?,Brand=?, PartDescription=?, Price=? WHERE PartID=?");
$stmt->bind_param("ssdii", $partName, $brand, $description, $price, $partID); //changed

// Execute the query
if ($stmt->execute()) {
    header("Location: interface/index.php"); // Redirect to the desired page
    exit;
} else {
    echo "Error updating record: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();

?>