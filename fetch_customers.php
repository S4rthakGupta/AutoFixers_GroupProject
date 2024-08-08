<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include 'db_connect.php'; // Adjust the path if necessary

// Check if the connection is established
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM Customers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Action</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["name"]) . "</td>
                <td>" . htmlspecialchars($row["email"]) . "</td>
                <td>" . htmlspecialchars($row["phone_number"]) . "</td>
                <td><a href='javascript:void(0)' onclick='fneditCustomer(\"" . 
                htmlspecialchars($row["customer_id"]) . "\", \"" . 
                htmlspecialchars($row["name"]) . "\", \"" . 
                htmlspecialchars($row["email"]) . "\", \"" . 
                htmlspecialchars($row["phone_number"]) . "\")'>Edit</a></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<tr><td colspan='4'>No customers found</td></tr>";
}

$conn->close();
?>