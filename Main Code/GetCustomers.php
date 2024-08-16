<!-- 
    Shakila Samaradiwakara 8886070 
    Sarthak Gupta 8971797 
    Abhishek Chachad 8971294     
-->

<?php

// Include database connection
include 'ConnectDB.php';

// Get all records from Customers table and execute the query on second line below
$sql = "SELECT * FROM Customers";
$result = $conn->query($sql);

// Check if there are any records returned from the query
if ($result->num_rows > 0) {
    // Using while loop for setting the data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["CustomerName"]) . "</td>
                <td>" . htmlspecialchars($row["Email"]) . "</td>
                <td>" . htmlspecialchars($row["Phone"]) . "</td>
                <td><a href='javascript:void(0)' onclick='fneditCustomer(" . 
                htmlspecialchars($row["CustomerID"]) . ", \"" . 
                htmlspecialchars($row["CustomerName"]) . "\", \"" . 
                htmlspecialchars($row["Email"]) . "\", \"" . 
                htmlspecialchars($row["Phone"]) . "\")'>Edit</a></td>
              </tr>";
    }
} else {
    // Display No customers found if no records returned from database
    echo "<tr><td colspan='4'>No customers found</td></tr>";
}

$conn->close();
?>
