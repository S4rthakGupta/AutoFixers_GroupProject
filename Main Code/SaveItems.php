<?php
// Include the connection file 
include "ConnectDB.php";

//Linking the variables to the post done by edit function
$partName = $_POST['model'];
$trademark = $_POST['trademark'];
$description = $_POST['description'];
$price = $_POST['price'];

// Here we will save the items into the database using the INSERT Query - Preparing and binding the data
$sql = "INSERT INTO Parts (PartName, Trademark, PartDescription, Price) VALUES (?, ?, ?, ?)";
$state = $conn->prepare($sql);
$state->bind_param("sssd", $partName, $trademark, $description, $price);

// Here we will execute the query and go to index.php page
if ($state->execute()) {
    header("Location: interface/index.php");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

//Below we are closing statement and connection
$state->close();
$conn->close();
?>