<?php
include '../auto_fixers.php'; // Include your database connection file

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customerID = $_POST['customer'];
    $items = $_POST['items'];
    $quantities = $_POST['quantities'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Insert order into Orders table
        $stmt = $conn->prepare("INSERT INTO Orders (CustomerID, OrderDate) VALUES (?, NOW())");
        $stmt->bind_param("i", $customerID);
        $stmt->execute();
        $orderID = $stmt->insert_id; // Get the inserted order ID
        $stmt->close();

        // Insert order items into OrderItems table
        $stmt = $conn->prepare("INSERT INTO OrderItems (OrderID, ItemID, Quantity) VALUES (?, ?, ?)");
        
        foreach ($items as $index => $itemID) {
            $quantity = $quantities[$index];
            $stmt->bind_param("iii", $orderID, $itemID, $quantity);
            $stmt->execute();
        }
        $stmt->close();

        // Commit the transaction
        $conn->commit();
        
        // Redirect to a success page or display a success message
        header("Location: success.php");
        exit();

    } catch (Exception $e) {
        // Rollback the transaction if something failed
        $conn->rollback();
        
        // Log the error and redirect to an error page
        error_log("Error processing order: " . $e->getMessage());
        header("Location: error.php");
        exit();
    }
} else {
    // If form is not submitted, redirect to home or show an error
    header("Location: index.php");
    exit();
}

// Close database connection
$conn->close();
?>