<?php

// Include the connection file 
include "ConnectDB.php";




$partID = $_POST['hdnId'];
$partName = $_POST['editmodel'];
$trademark = $_POST['editTrademark'];
$description = $_POST['editdescription'];
$price = $_POST['editprice'];

// Prepare and bind
$stmt = $conn->prepare("UPDATE Parts SET PartName=?,Trademark=?, PartDescription=?, Price=? WHERE PartID=?");
$stmt->bind_param("sssii", $partName, $trademark, $description, $price, $partID); //changed

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