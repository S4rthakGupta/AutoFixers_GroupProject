<!-- 
    Shakila Samaradiwakara 8886070 
    Sarthak Gupta 8971797 
    Abhishek Chachad 8971294     
-->

<?php
// We need this to connect to out database
include "ConnectDB.php";

//Linking the variables to the post done by edit function
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

// Here we will save the items into the database using the INSERT Query - Preparing and binding the data
$sql = "INSERT INTO Customers (CustomerName, Email, Phone) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $email, $phone);

// Here we will execute the query and go to CUSTOMERS.php page
if ($stmt->execute()) {
    header("Location: interface/customers.php");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

//Below we are closing statement and connection
$stmt->close();
$conn->close();
?>