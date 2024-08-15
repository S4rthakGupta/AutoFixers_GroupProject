<?php



//include connection file 
include "ConnectDB.php";

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$sql = "INSERT INTO Customers (CustomerName, Email, Phone) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $email, $phone);

if ($stmt->execute()) {
    header("Location: interface/customers.php"); // Replace "success.php" with your desired page
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();

$conn->close();
?>