<?php

// Include database connection
include 'db_connect.php';

// Retrieve POST data
$customerId = isset($_POST['editId']) ? $_POST['editId'] : '';
$newName = isset($_POST['editname']) ? $_POST['editname'] : '';
$newEmail = isset($_POST['editemail']) ? $_POST['editemail'] : '';
$newPhone = isset($_POST['editphone']) ? $_POST['editphone'] : '';

// Check if customer ID is provided
if (empty($customerId)) {
    echo "Error: Customer ID is required.";
    exit;
}

// Fetch existing customer data
$stmt = $conn->prepare("SELECT name, email, phone_number FROM Customers WHERE customer_id = ?");
$stmt->bind_param("i", $customerId);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

// Check if customer exists
if (!$customer) {
    echo "Error: Customer not found.";
    exit;
}

// Initialize an array to hold fields that need updating
$updateFields = [];
$updateValues = [];

// Compare each field and add to update array if different
if ($newName !== $customer['name']) {
    $updateFields[] = "name = ?";
    $updateValues[] = $newName;
}

if ($newEmail !== $customer['email']) {
    $updateFields[] = "email = ?";
    $updateValues[] = $newEmail;
}

if ($newPhone !== $customer['phone_number']) {
    $updateFields[] = "phone_number = ?";
    $updateValues[] = $newPhone;
}

// If there are no changes, do nothing
if (empty($updateFields)) {
    echo "No changes detected.";
    exit;
}

// Build the SQL statement dynamically
$sql = "UPDATE Customers SET " . implode(", ", $updateFields) . " WHERE customer_id = ?";
$updateValues[] = $customerId;

// Prepare the SQL statement
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat("s", count($updateFields)) . "i", ...$updateValues);

// Execute the query
if ($stmt->execute()) {
    echo "Record updated successfully.";
} else {
    echo "Error updating record: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>