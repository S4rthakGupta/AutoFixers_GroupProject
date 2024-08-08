<?php
// Include database connection
include 'auto_fixers.php';

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