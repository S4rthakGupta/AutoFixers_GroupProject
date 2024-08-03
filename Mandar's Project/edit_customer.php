<?php
// Include database connection
include 'dbconnect.php';

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
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
