<?php
// Include database connection
include 'dbconnect.php';

// Retrieve POST data
$customer_id = $_POST['editId'];
$name = $_POST['editname'];
$email = $_POST['editemail'];
$phone_number = $_POST['editphone'];

// Prepare and bind
$stmt = $conn->prepare("UPDATE Customers SET name=?, phone_number=?, email=? WHERE customer_id=?");
$stmt->bind_param("sisi", $name, $email, $phone_number, $customer_id);

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
