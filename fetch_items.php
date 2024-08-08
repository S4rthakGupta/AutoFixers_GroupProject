<?php
// Include database connection
include 'auto_fixers.php';

$sql = "SELECT * FROM Parts";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Item Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Action</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["name"]) . "</td>
                <td>$" . number_format($row["price"], 2) . "</td>
                <td>" . htmlspecialchars($row["stock"]) . "</td>
                <td><a href='javascript:void(0)' onclick=\"fneditItem('" . 
                htmlspecialchars($row["part_id"]) . "', '" . 
                htmlspecialchars($row["name"]) . "', '" . 
                htmlspecialchars($row["price"]) . "', '" . 
                htmlspecialchars($row["stock"]) . "')\">Edit</a></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<tr><td colspan='4'>No items found</td></tr>";
}

$conn->close();
?>