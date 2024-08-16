<!-- 
    Shakila Samaradiwakara 8886070 
    Sarthak Gupta 8971797 
    Abhishek Chachad 8971294     
-->

<?php
// We need this to connect to out database
include 'ConnectDB.php';

//Linking the variables to the post done by edit function
$customerId = $_POST['editId'];
$name = $_POST['editname'];
$email = $_POST['editemail'];
$phone = $_POST['editphone'];

// Here we will UPDATE the items into the database using the UPDATE Query - Preparing and binding the data
$stmt = $conn->prepare("UPDATE Customers SET CustomerName=?, Email=?, Phone=? WHERE CustomerID=?");
$stmt->bind_param("sssi", $name, $email, $phone, $customerId);

// Here we will execute the query and go to CUSTOMERS.php page
if ($stmt->execute()) {
    header("Location: interface/customers.php");
    exit;
} else {
    echo "Error updating record: " . $stmt->error;
}

//Below we are closing statement and connection
$stmt->close();
$conn->close();
?>
