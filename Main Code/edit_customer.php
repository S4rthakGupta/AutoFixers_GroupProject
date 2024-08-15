<?php

//  8980277 Mandar Sankhe
//  8961944 Susmi Rani
//  8969031 Dhruvinkumar Jayani

// Include database connection
include 'db_connect.php';

// Retrieve POST data
$customerId = $_POST['editId'];
$name = $_POST['editname'];
$email = $_POST['editemail'];
$phone = $_POST['editphone'];

// Prepare and bind
$stmt = $conn->prepare("UPDATE Customers SET CustomerName=?, Email=?, Phone=? WHERE CustomerID=?");
$stmt->bind_param("sssi", $name, $email, $phone, $customerId);

// Execute the query
if ($stmt->execute()) {
    header("Location: interface/customers.php"); // Replace "success.php" with your desired page
    exit;
} else {
    echo "Error updating record: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
