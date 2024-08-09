<?php
include 'db_connect.php';

$sql = "SELECT customer_id, name, email, phone_number FROM Customers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['phone_number']) . "</td>";
        echo "<td><button onclick=\"fneditCustomer('{$row['customer_id']}', '{$row['name']}', '{$row['email']}', '{$row['phone_number']}')\">Edit</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No customers found.</td></tr>";
}

$conn->close();
?>