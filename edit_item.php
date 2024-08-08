<?php
// Include database connection
include 'auto_fixers.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve POST data
    $itemID = $_POST['hdnId'];
    $itemName = $_POST['editmodel'];
    $brand = $_POST['editbrand'];
    $description = $_POST['editdescription'];
    $price = $_POST['editprice'];

    // Prepare and bind
    $stmt = $conn->prepare("UPDATE Parts SET name=?, price=?, stock=? WHERE part_id=?");
    $stmt->bind_param("ssis", $itemName, $price, $stock, $itemID);

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