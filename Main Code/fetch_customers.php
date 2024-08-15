<?php




// Include database connection
include 'db_connect.php';

$sql = "SELECT * FROM Customers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
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
    echo "<tr><td colspan='4'>No customers found</td></tr>";
}

$conn->close();
?>
