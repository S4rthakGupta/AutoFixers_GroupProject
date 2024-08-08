<?php
// Error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include '../db_connect.php'; // Adjust the path if necessary

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve POST data
    $customerId = $_POST['editId'];
    $name = $_POST['editname'];
    $email = $_POST['editemail'];
    $phone = $_POST['editphone'];

    // Prepare and bind
    $stmt = $conn->prepare("UPDATE Customers SET name=?, email=?, phone_number=? WHERE customer_id=?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssis", $name, $email, $phone, $customerId);

    // Execute the query
    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>