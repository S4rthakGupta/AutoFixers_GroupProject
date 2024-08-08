<?php
// Include database connection
include 'auto_fixers.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve POST data
    $customerId = $_POST['editId'];
    $name = $_POST['editname'];
    $email = $_POST['editemail'];
    $phone = $_POST['editphone'];

    // Prepare and bind
    $stmt = $conn->prepare("UPDATE Customers SET name=?, email=?, phone_number=? WHERE customer_id=?");
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