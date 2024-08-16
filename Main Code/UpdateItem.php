<!-- 
    Shakila Samaradiwakara 8886070 
    Sarthak Gupta 8971797 
    Abhishek Chachad 8971294     
-->

<?php
// We need this to connect to out database
include "ConnectDB.php";

//Linking the variables to the post done by edit function
$partID = $_POST['hdnId'];
$partName = $_POST['editmodel'];
$trademark = $_POST['editTrademark'];
$description = $_POST['editdescription'];
$price = $_POST['editprice'];

// Preparing and binding the data
$stmt = $conn->prepare("UPDATE Parts SET PartName=?,Trademark=?, PartDescription=?, Price=? WHERE PartID=?");
$stmt->bind_param("sssii", $partName, $trademark, $description, $price, $partID); //changed

// Here we will execute the query and go to index.php page
if ($stmt->execute()) {
    header("Location: interface/index.php");
    exit;
} else {
    echo "Error updating record: " . $stmt->error;
}
//Below we are closing statement and connection
$stmt->close();
$conn->close();

?>